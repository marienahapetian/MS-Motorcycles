<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function edit(): Response
    {
        $product = [
            "title" => "Harley Davidson",
            "mainImage" => "/images/uploads/S0-harley-davidson-prepare-un-nouveau-custom-pour-2021-186722.jpg",
            "galleryImages" => ["/images/uploads/carlos-unique-beitragsbild-545x364.jpg.pagespeed.ce.7i8a8sDMzQ.jpg", "/images/uploads/carlos-unique-beitragsbild-545x364.jpg.pagespeed.ce.7i8a8sDMzQ.jpg", "/images/uploads/carlos-unique-beitragsbild-545x364.jpg.pagespeed.ce.7i8a8sDMzQ.jpg"],
            "price" => "2500€",
            "year" => 2015,
            "description" => "Embodying the raw, wayward spirit of rock ‘n’ roll, the Kilburn portable active stereo speaker takes the unmistakable look  and sound of  Marshall, unplugs the chords, and takes the show  on the road. Weighing in under 7 pounds, the Kilburn is a lightweight piece of vintage styled engineering. Setting the bar as one of the loudest speakers in its  class,  the Kilburn is a compact, stout-hearted hero with a  well-balanced audio which boasts a clear midrange and extended highs for a sound that is both articulate and pronounced. The analogue knobs allow you to fine tune the controls to your personal preferences while the  guitar-influenced leather strap enables easy and stylish travel.",
            "specs" => [
                ['label' => 'Stand Up', 'value' => '35"L x 24"W x 37-45"H'],
                ['label' => 'Folded w/o wheels', 'value' => '32.5"L x 18.5"W x 16.5"H'],
                ['label' => 'Folded w wheels', 'value' => '32.5"L x 24"W x 18.5"H'],
            ]
        ];
        return $this->render("dashboard/product/edit.html.twig", [
            "product" => $product
        ]);
    }

    #[Route('/product/add', name: 'product_add')]
    public function add(): Response
    {
        return $this->render("dashboard/product/add.html.twig", []);
    }
}
