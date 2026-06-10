<?php

namespace App\Controller\Dashboard;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Services\CloudinaryImageUploader;
use App\Services\ImageUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{
    #[Route("/dashboard/categories", "dashboard_categories")]
    public function list_categories(EntityManagerInterface $entityManager, Request $request): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAllCategories($request->query->getInt('page', 1));
        return $this->render("dashboard/category/list.html.twig", [
            'categories' => $categories,
            'data' => $categories,
        ]);
    }

    #[Route("/dashboard/category/edit/{id}", "category_edit")]
    public function edit(Request $request, EntityManager $entityManager, Category $category, CloudinaryImageUploader $imageUploader): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $file = $form->get('icon')->getData();
                if ($file) {
                    $newFilename = $imageUploader->upload($file);

                    $category->setIcon($newFilename);
                }


                $entityManager->persist($category);
                $entityManager->flush();

                $this->addFlash('success', 'Catégorie modifiée!');

                return $this->redirectToRoute('dashboard_categories');
            } catch (Exception $e) {
                $form->addError(new FormError(
                    'An error occurred while editing the category.'
                ));
            }
        }

        return $this->render("dashboard/category/edit.html.twig", [
            'category' => $category,
            'form' => $form
        ]);
    }

    #[Route("/dashboard/category/add", "category_add")]
    public function add(Request $request, EntityManagerInterface $entityManager, CloudinaryImageUploader $imageUploader): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $category = $form->getData();
                $file = $form->get('icon')->getData();
                if ($file) {
                    $newFilename = $imageUploader->upload($file);

                    $category->setIcon($newFilename);
                }
                $category->setCreatedAt(new DateTime());
                $entityManager->persist($category);
                $entityManager->flush();
                $this->addFlash('success', 'Catégorie crée!');
                return $this->redirectToRoute('dashboard_categories');
            } catch (Exception $e) {
                $form->addError(new FormError(
                    'An error occurred while adding the category.'
                ));
            }
        }
        return $this->render("dashboard/category/add.html.twig", ['form' => $form]);
    }


    #[Route('/category/{id}/delete', name: 'category_delete')]
    public function delete(Category $category, ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash('success', 'Catégorie Supprimé!');

        return $this->redirectToRoute('dashboard_categories');
    }
}
