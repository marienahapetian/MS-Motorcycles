<?php

namespace App\Controller\Dashboard;

use App\Entity\Feature;
use App\Form\FeatureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FeatureController extends AbstractController
{

    #[Route("/dashboard/features", "dashboard_features")]
    public function list(): Response
    {
        $features = [
            ["id" => 1, "name" => "Folded w Wheels", "categories" => ["bike"], "values" => ["32.5″L x 18.5″W x 16.5″H"], "createdAt" => "2026-03-28"],
            ["id" => 2, "name" => "Folded wo Wheels", "categories" => ["bike"], "values" => ["32.5″L x 18.5″W x 16.5″H"], "createdAt" => "2026-03-28"],
            ["id" => 3, "name" => "Size", "categories" => ["bracelet"], "values" => ["xs", "s", "m", "TU"], "createdAt" => "2026-03-28"],
            ["id" => 4, "name" => "Weight", "categories" => ["bike", "bracelet", "oil"], "values" => ["1kg", "2kg", "3kg"], "createdAt" => "2026-03-28"],
            ["id" => 5, "name" => "Color", "categories" => ["bike", "tshirt", "bracelet"], "values" => ["red", "green", "blue"], "createdAt" => "2026-03-28"],
        ];
        $currentPage = 1;
        $totalPages = 5;
        return $this->render("dashboard/feature/list.html.twig", [
            'features' => $features,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route("/dashboard/feature/edit/{id}", "feature_edit")]
    public function edit(): Response
    {
        $categories = [
            ["id" => 1, "name" => "Bike", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 2, "name" => "Helmet", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 3, "name" => "Oil", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 4, "name" => "Jacket", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 5, "name" => "Bracelet", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 6, "name" => "T-Shirt", "count" => 10, "createdAt" => "2026-03-28"],
        ];
        $feature = ["id" => 1, "name" => "Folded w Wheels", "categories" => ["Bike"], "values" => ["32.5″L x 18.5″W x 16.5″H"], "createdAt" => "2026-03-28"];
        return $this->render("dashboard/feature/edit.html.twig", [
            'feature' => $feature,
            'categories' => $categories
        ]);
    }

    #[Route("/dashboard/feature/add", "feature_add")]
    public function add(): Response
    {
        $feature = new Feature();
        $form = $this->createForm(FeatureType::class, $feature);
        $categories = [
            ["id" => 1, "name" => "Bike", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 2, "name" => "Helmet", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 3, "name" => "Oil", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 4, "name" => "Jacket", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 5, "name" => "Bracelet", "count" => 10, "createdAt" => "2026-03-28"],
            ["id" => 6, "name" => "T-Shirt", "count" => 10, "createdAt" => "2026-03-28"],
        ];
        return $this->render("dashboard/feature/add.html.twig", [
            'categories' => $categories,
            'form' => $form
        ]);
    }
}
