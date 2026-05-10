<?php

namespace App\Controller\Dashboard;

use App\Entity\Category;
use App\Entity\Feature;
use App\Form\FeatureType;
use Doctrine\Migrations\Configuration\EntityManager\ManagerRegistryEntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FeatureController extends AbstractController
{

    #[Route("/dashboard/features", "dashboard_features")]
    public function list(EntityManagerInterface $em, Request $request): Response
    {
        $features = $em->getRepository(Feature::class)->findAllFeatures($request->query->getInt('page', 1));

        return $this->render("dashboard/feature/list.html.twig", [
            'features' => $features,
            'data' => $features
        ]);
    }

    #[Route("/dashboard/feature/edit/{id}", "feature_edit")]
    public function edit(Request $request, Feature $feature, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(FeatureType::class, $feature);
        $form->handleRequest($request);

        $entityManager = $doctrine->getManager();

        $categories = $doctrine->getRepository(Category::class)->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($feature);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_features');
        }
        return $this->render("dashboard/feature/edit.html.twig", [
            'feature' => $feature,
            'form' => $form,
            'categories' => $categories
        ]);
    }

    #[Route("/dashboard/feature/add", "feature_add")]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $feature = new Feature();
        $form = $this->createForm(FeatureType::class, $feature);
        $form->handleRequest($request);

        $entityManager = $doctrine->getManager();

        $categories = $doctrine->getRepository(Category::class)->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $feature = $form->getData();
            $entityManager->persist($feature);
            $entityManager->flush();
            return $this->redirectToRoute('dashboard_features');
        }

        return $this->render("dashboard/feature/add.html.twig", [
            'categories' => $categories,
            'form' => $form
        ]);
    }

    #[Route('/feature/{id}/delete', name: 'feature_delete')]
    public function delete(Feature $feature, ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($feature);
        $entityManager->flush();
        $this->addFlash('success', 'Caractéristique Supprimé!');

        return $this->redirectToRoute('dashboard_features');
    }
}
