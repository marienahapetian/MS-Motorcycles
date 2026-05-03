<?php

namespace App\Controller\Dashboard;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface as EntityManager;

class ProductController extends AbstractController
{
    #[Route("/dashboard/products", "dashboard_products")]
    public function list(): Response
    {
        $products = [
            ["id" => 1, "name" => "Harley Davidson", "type" => "bike", "price" => "2500€", "createdAt" => "2026-03-28"],
            ["id" => 2, "name" => "Harley Davidson", "type" => "bike", "price" => "2500€", "createdAt" => "2026-03-28"],
            ["id" => 3, "name" => "Harley Davidson", "type" => "bike", "price" => "2500€", "createdAt" => "2026-03-28"],
            ["id" => 4, "name" => "Harley Davidson", "type" => "bike", "price" => "2500€", "createdAt" => "2026-03-28"],
            ["id" => 5, "name" => "Harley Davidson", "type" => "bike", "price" => "2500€", "createdAt" => "2026-03-28"],
            ["id" => 6, "name" => "Harley Davidson", "type" => "bike", "price" => "2500€", "createdAt" => "2026-03-28"],
        ];
        $currentPage = 1;
        $totalPages = 5;
        return $this->render("dashboard/product/list.html.twig", [
            'products' => $products,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/product/edit/{id}', name: 'product_edit')]
    public function edit(EntityManager $entityManager, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $product = new Product();

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
    public function add(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            return $this->redirectToRoute('dashboard_products');
        }
        return $this->render("dashboard/product/add.html.twig", ['form' => $form]);
    }
}
