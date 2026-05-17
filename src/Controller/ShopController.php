<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\FeatureRepository;
use App\Repository\ProductFeatureRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'shop')]
    public function index(Request $request, ProductRepository $pr, CategoryRepository $cr, ProductFeatureRepository $pfr): Response
    {
        $products = $pr->findAllProducts($request->query->getInt('page', 1));
        $categories = $cr->getCategoriesFromProducts($products);
        $colors = $pfr->getFeaturesFromProducts('couleur', $products);
        $priceRanges = [
            ['value' => 'lt1000', 'label' => '< 1000 €'],
            ['value' => '1000-2000', 'label' => '1000 - 2000 €'],
            ['value' => '2000-5000', 'label' => '2000 - 5000 €'],
        ];

        return $this->render('shop.html.twig', [
            'page_title' => 'Shop',
            'categories' => $categories,
            'prices' => $priceRanges,
            'colors' => $colors,
            'products' => $products,
            'data' => $products,
            'hasSidebar' => true
        ]);
    }
}
