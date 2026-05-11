<?php

namespace App\Controller\Dashboard;

use App\Entity\Product;
use App\Entity\ProductImage;
use App\Form\ProductType;
use App\Services\ImageUploader;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    public function edit(EntityManager $entityManager, Request $request, Product $product, SluggerInterface $slugger, ImageUploader $imageUploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('images')->getData();
            foreach ($files as $index => $file) {

                $newFilename = $imageUploader->upload($file, $slugger);

                $image = new ProductImage();
                $image->setImage('/images/uploads/' . $newFilename);

                $image->setIsMain(!$product->getMainImage());

                $product->addImage($image);
            }
            $product->setModified(new DateTime());
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Article Modifié!');

            return $this->redirectToRoute('dashboard_products');
        }
        return $this->render("dashboard/product/edit.html.twig", [
            "product" => $product,
            "form" => $form
        ]);
    }

    #[Route('/dashboard/product/add', name: 'product_add')]
    public function add(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, ImageUploader $imageUploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setAdded(new DateTime());
            $files = $form->get('images')->getData();
            foreach ($files as $index => $file) {
                $newFilename = $imageUploader->upload($file, $slugger);

                $image = new ProductImage();
                $image->setImage('/images/uploads/' . $newFilename);

                $image->setIsMain(!$product->getMainImage());

                $product->addImage($image);
            }
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Article crée!');

            return $this->redirectToRoute('dashboard_products');
        }
        return $this->render("dashboard/product/add.html.twig", ['form' => $form]);
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
}
