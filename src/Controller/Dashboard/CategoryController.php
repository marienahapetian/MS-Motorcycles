<?php

namespace App\Controller\Dashboard;

use App\Entity\Category;
use App\Form\CategoryType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route("/dashboard/categories", "dashboard_categories")]
    public function list_categories(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $currentPage = 1;
        $totalPages = 5;
        return $this->render("dashboard/category/list.html.twig", [
            'categories' => $categories,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route("/dashboard/category/edit/{id}", "category_edit")]
    public function edit(Request $request, EntityManager $entityManager, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_categories');
        }

        return $this->render("dashboard/category/edit.html.twig", [
            'category' => $category,
            'form' => $form
        ]);
    }

    #[Route("/dashboard/category/add", "category_add")]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $category->setCreatedAt(new DateTime());
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('dashboard_categories');
        }
        return $this->render("dashboard/category/add.html.twig", ['form' => $form]);
    }
}
