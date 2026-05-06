<?php

namespace App\Controller\Dashboard;

use App\Entity\Brand;
use App\Form\BrandType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrandController extends AbstractController
{
    #[Route('/dashboard/brands', name: 'dashboard_brands')]
    public function list_brands(EntityManagerInterface $entityManager): Response
    {
        $brands = $entityManager->getRepository(Brand::class)->findAll();
        $currentPage = 1;
        $totalPages = 5;
        return $this->render('dashboard/brand/list.html.twig', ['brands' => $brands, 'totalPages' => $totalPages, 'currentPage' => $currentPage]);
    }

    #[Route("/dashboard/brand/edit/{id}", "brand_edit")]
    public function edit(Request $request, EntityManagerInterface $entityManager, Brand $brand): Response
    {
        $form = $this->createForm(BrandType::class, $brand);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brand);
            $entityManager->flush();

            $this->addFlash('success', 'Marque modifiée!');

            return $this->redirectToRoute('dashboard_brands');
        }
        return $this->render("dashboard/brand/edit.html.twig", [
            'brand' => $brand,
            'form' => $form
        ]);
    }

    #[Route("/dashboard/brand/add", "brand_add")]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brand->setCreatedAt(new DateTime());
            $entityManager->persist($brand);
            $entityManager->flush();

            $this->addFlash('success', 'Marque crée!');

            return $this->redirectToRoute('dashboard_brands');
        }
        return $this->render("dashboard/brand/add.html.twig", [
            'brand' => $brand,
            'form' => $form
        ]);
    }

    #[Route('/brand/{id}/delete', name: 'brand_delete')]
    public function delete(Brand $brand, PersistenceManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($brand);
        $entityManager->flush();
        $this->addFlash('success', 'Marque Supprimé!');

        return $this->redirectToRoute('dashboard_brands');
    }
}
