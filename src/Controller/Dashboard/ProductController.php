<?php

namespace App\Controller\Dashboard;

use App\Entity\Product;
use App\Entity\ProductImage;
use App\Form\ProductType;
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
    public function list(ManagerRegistry $doctrine): Response
    {
        $products = $doctrine->getRepository(Product::class)->findAll();
        $currentPage = 1;
        $totalPages = 5;
        return $this->render("dashboard/product/list.html.twig", [
            'products' => $products,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/product/edit/{id}', name: 'product_edit')]
    public function edit(EntityManager $entityManager, Request $request, Product $product): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_products');
        }
        return $this->render("dashboard/product/edit.html.twig", [
            "product" => $product,
            "form" => $form
        ]);
    }

    #[Route('/product/add', name: 'product_add')]
    public function add(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $product = new Product();
        $product->setName("Harley Davidson 2.0");
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product->setAdded(new DateTime());
            $files = $form->get('images')->getData();
            foreach ($files as $index => $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeName = $slugger->slug($originalName);
                $newFilename = $safeName . '-' . uniqid() . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('uploads_dir'),
                    $newFilename
                );

                $image = new ProductImage();
                $image->setImage('/images/uploads/' . $newFilename);

                if ($index === 0) {
                    $image->setIsMain(true);
                } else {
                    $image->setIsMain(false);
                }

                $product->addImage($image);
            }
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_products');
        }
        return $this->render("dashboard/product/add.html.twig", ['form' => $form]);
    }

    #[Route('/product/{id}/delete', name: 'product_delete')]
    public function delete(Product $product, ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('dashboard_products');
    }
}
