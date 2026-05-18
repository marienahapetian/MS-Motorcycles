<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'shop')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $products = $em->getRepository(Product::class)->findAllProducts($request->query->getInt('page', 1));
        return $this->render('shop.html.twig', [
            'page_title' => 'Shop',
            'categories' => [
                ['id' => 1, 'name' => 'Sport Bikes'],
                ['id' => 2, 'name' => 'Beginner Bikes'],
            ],
            'prices' => [
                ['value' => 'lt1000', 'label' => '< 1000 €'],
                ['value' => '1000-2000', 'label' => '1000 - 2000 €'],
                ['value' => '2000-5000', 'label' => '2000 - 5000 €'],
            ],
            'colors' => [
                ['name' => 'red', 'hex' => '#c0392b'],
                ['name' => 'blue', 'hex' => '#3c40c6'],
                ['name' => 'green', 'hex' => '#6ab04c'],
                ['name' => 'black', 'hex' => '#000000'],
                ['name' => 'white', 'hex' => '#ecf0f1'],
            ],
            'products' => $products,
            'data' => $products,
            'hasSidebar' => true
        ]);
    }
}
