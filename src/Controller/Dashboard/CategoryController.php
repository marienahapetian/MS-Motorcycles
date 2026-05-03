<?php

namespace App\Controller\Dashboard;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route("/dashboard/categories", "dashboard_categories")]
    public function list_categories(): Response
    {
        $categories = [
            ["id" => 1, "name" => "Bike", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 2, "name" => "Helmet", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 3, "name" => "Oil", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 4, "name" => "Jacket", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 5, "name" => "Bracelet", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 6, "name" => "T-Shirt", "count" => 10, "createdAt" => "2026-03-28"],
        ];
        $currentPage = 1;
        $totalPages = 5;
        return $this->render("dashboard/category/list.html.twig", [
            'categories' => $categories,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route("/dashboard/category/edit/{id}", "category_edit")]
    public function edit(): Response
    {
        $category = ["id" => 1, "name" => "Bike", "thumbnail" => "", "count" => 10, "createdAt" => "2026-03-28"];
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        return $this->render("dashboard/category/edit.html.twig", [
            'category' => $category,
            'form' => $form
        ]);
    }

    #[Route("/dashboard/category/add", "category_add")]
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            return $this->redirectToRoute('dashboard_categories');
        }
        return $this->render("dashboard/category/add.html.twig", ['form' => $form]);
    }
}
