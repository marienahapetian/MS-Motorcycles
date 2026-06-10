<?php

namespace App\Controller\Dashboard;

use App\Entity\Brand;
use App\Form\BrandType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Exception;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrandController extends AbstractController
{
    #[Route('/dashboard/brands', name: 'dashboard_brands')]
    public function list_brands(EntityManagerInterface $entityManager, Request $request): Response
    {
        $brands = $entityManager->getRepository(Brand::class)->findAllBrands($request->query->getInt('page', 1));
        return $this->render('dashboard/brand/list.html.twig', ['brands' => $brands, 'data' => $brands]);
    }

    #[Route("/dashboard/brand/edit/{id}", "brand_edit")]
    public function edit(Request $request, EntityManagerInterface $entityManager, Brand $brand): Response
    {
        $form = $this->createForm(BrandType::class, $brand);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($brand);
                $entityManager->flush();

                $this->addFlash('success', 'Marque modifiée!');

                return $this->redirectToRoute('dashboard_brands');
            } catch (Exception $e) {
                $form->addError(new FormError(
                    'An error occurred while editing the brand.'
                ));
            }
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
            try {
                $brand->setCreatedAt(new DateTime());
                $entityManager->persist($brand);
                $entityManager->flush();

                $this->addFlash('success', 'Marque crée!');

                return $this->redirectToRoute('dashboard_brands');
            } catch (Exception $e) {
                $form->addError(new FormError(
                    'An error occurred while adding the brand.'
                ));
            }
        }
        return $this->render("dashboard/brand/add.html.twig", [
            'brand' => $brand,
            'form' => $form
        ]);
    }

    #[Route('/brand/{id}/delete', name: 'brand_delete')]
    public function delete(Brand $brand, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager->remove($brand);
        $entityManager->flush();
        $this->addFlash('success', 'Marque Supprimé!');

        return $this->redirectToRoute('dashboard_brands');
    }
}
