<?php

namespace App\Controller\Dashboard;

use App\Entity\Product;
use App\Entity\ProductFeature;
use App\Entity\ProductImage;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\FeatureRepository;
use App\Repository\ProductRepository;
use App\Services\CloudinaryImageUploader;
use App\Services\ImageUploader;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Sami\Parser\Filter\CloudinaryFilter;
use Symfony\Component\Form\FormError;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    #[Route("/dashboard/products", "dashboard_products")]
    public function list(Request $request, EntityManagerInterface $em): Response
    {
        $products = $em->getRepository(Product::class)->findAllProducts($request->query->getInt('page', 1));
        return $this->render("dashboard/product/list.html.twig", [
            'products' => $products,
            'data' => $products
        ]);
    }

    #[Route('/dashboard/product/edit/{id}', name: 'product_edit')]
    public function edit(Product $product, EntityManager $entityManager, Request $request, FeatureRepository $featureRepository, CloudinaryImageUploader $imageUploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        // available features for product's type
        $availableFeatures = [];

        foreach ($product->getCategories() as $category) {
            foreach ($category->getFeatures() as $feature) {
                $availableFeatures[$feature->getId()] = $feature;
            }
        }


        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // upload images, gallery
                $files = $form->get('images')->getData();
                foreach ($files as $index => $file) {

                    $newFilename = $imageUploader->upload($file);

                    $image = new ProductImage();
                    $image->setImage($newFilename);

                    $image->setIsMain(!$product->getMainImage());

                    $product->addImage($image);
                }

                //update features
                $featuresData = $request->request->all('features');
                foreach ($featuresData as $featureId => $value) {

                    if (!$value) {
                        continue;
                    }

                    $feature = $featureRepository->find($featureId);

                    // find existing ProductFeature
                    $productFeature = null;

                    foreach ($product->getFeatures() as $existing) {

                        if ($existing->getFeature()->getId() == $featureId) {
                            $productFeature = $existing;
                            break;
                        }
                    }

                    if (!$productFeature) {
                        $productFeature = new ProductFeature();
                        $productFeature->setProduct($product);
                        $productFeature->setFeature($feature);

                        $product->getFeatures()->add($productFeature);
                    }

                    $productFeature->setValue($value);

                    $entityManager->persist($productFeature);
                }
                $product->setModified(new DateTime());
                $entityManager->persist($product);
                $entityManager->flush();

                $this->addFlash('success', 'Article Modifié!');

                return $this->redirectToRoute('dashboard_products');
            } catch (Exception $e) {
                $form->addError(new FormError(
                    'An error occurred while saving the product.'
                ));
            }
        }
        return $this->render("dashboard/product/edit.html.twig", [
            "product" => $product,
            "form" => $form,
            "availableFeatures" => $availableFeatures,
        ]);
    }

    #[Route('/dashboard/product/add', name: 'product_add')]
    public function add(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, CloudinaryImageUploader $imageUploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $product = $form->getData();
                $product->setAdded(new DateTime());
                $files = $form->get('images')->getData();
                foreach ($files as $index => $file) {
                    $newFilename = $imageUploader->upload($file);

                    $image = new ProductImage();
                    $image->setImage($newFilename);

                    $image->setIsMain(!$product->getMainImage());

                    $product->addImage($image);
                }
                $entityManager->persist($product);
                $entityManager->flush();
                $this->addFlash('success', 'Article crée!');

                return $this->redirectToRoute('dashboard_products');
            } catch (Exception $e) {
                $form->addError(new FormError(
                    'An error occurred while adding the product.'
                ));
            }
        }
        return $this->render("dashboard/product/add.html.twig", [
            'form' => $form,
        ]);
    }

    #[Route('/dashboard/product/{id}/delete', name: 'product_delete')]
    public function delete(Product $product, ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($product);
        $entityManager->flush();
        $this->addFlash('success', 'Article Supprimé!');

        return $this->redirectToRoute('dashboard_products');
    }

    #[Route('/dashboard/product/image/{id}/delete', name: 'product_image_delete')]
    public function deleteImage(ProductImage $image, EntityManagerInterface $entityManager): Response
    {
        $filePath = $this->getParameter('uploads_dir') . '/' . basename($image->getImage());

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $entityManager->remove($image);
        $entityManager->flush();

        $this->addFlash('success', 'Image supprimé!');

        return $this->redirectToRoute('dashboard_products');
    }

    #[Route('/dashboard/product/image/{id}/main', name: 'product_image_main')]
    public function makeMainImage(ProductImage $image, EntityManagerInterface $entityManager): Response
    {
        $product = $image->getProduct();
        foreach ($product->getImages() as $img) {
            $img->setIsMain(false);
        }

        $image->setIsMain(true);

        $entityManager->flush();

        $this->addFlash('success', 'Image Principale Changé!');

        return $this->redirectToRoute('dashboard_products');
    }

    #[Route('/dashboard/products/features', name: 'dashboard_product_features')]
    public function featuresByCategory(
        Request $request,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    ): Response {

        $categoryIds = $request->query->all('categories');

        $productId = $request->query->get('product');

        $product = null;

        if ($productId) {
            $product = $productRepository->find($productId);
        }

        $features = [];

        foreach ($categoryIds as $categoryId) {

            $category = $categoryRepository->find($categoryId);

            if (!$category) {
                continue;
            }

            foreach ($category->getFeatures() as $feature) {
                $features[$feature->getId()] = $feature;
            }
        }

        return $this->render(
            'dashboard/partials/product/_features.html.twig',
            [
                'features' => $features,
                'product' => $product,
            ]
        );
    }

    #[Route('/dashboard/products/brands', name: 'dashboard_product_brands')]
    public function brandsByCategory(
        Request $request,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    ): Response {

        $categoryIds = $request->query->all('categories');

        $productId = $request->query->get('product');

        $product = null;

        if ($productId) {
            $product = $productRepository->find($productId);
        }

        $form = $this->createForm(ProductType::class, $product);

        $brands = [];

        foreach ($categoryIds as $categoryId) {

            $category = $categoryRepository->find($categoryId);

            if (!$category) {
                continue;
            }

            foreach ($category->getBrands() as $brand) {
                $brands[$brand->getId()] = $brand;
            }
        }

        return $this->render(
            'dashboard/partials/product/_brand.html.twig',
            [
                'brands' => $brands,
                'product' => $product,
                'form' => $form->createView(),
            ]
        );
    }
}
