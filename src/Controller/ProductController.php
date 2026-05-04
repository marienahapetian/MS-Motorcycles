<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{id<\d+>}-{slug}', name: 'product_show')]
    public function index($id, $slug, ManagerRegistry $doctrine): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);
        if (!$product || $product->getSlug() != $slug)
            throw $this->createNotFoundException('Product not found');

        return $this->render("single.html.twig", [
            "page_title" => "Bike",
            "product" => $product
        ]);
    }
}
