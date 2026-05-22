<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\FeatureValueMapper;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'shop')]
    public function index(Request $request, EntityManagerInterface $em, FeatureValueMapper $mapper): Response
    {
        $products = $em->getRepository(Product::class)->findAllProducts($request->query->getInt('page', 1));
        $categories = $em->getRepository(Product::class)->findUsedCategories();
        $brands = $em->getRepository(Product::class)->findUsedBrands();
        $colors = $em->getRepository(Product::class)->findUsedColors();
        $categories = array_values($categories);
        $brands = array_values($brands);
        $colors = array_values($colors);
        foreach ($colors as &$color) {
            $color['label'] = $mapper->mapColor($color['value']);
        }

        $maxPrice = $em->getRepository(Product::class)->getMaxPrice();
        $prices = [];

        $ranges = [
            [0, 1000],
            [1000, 5000],
            [5000, 10000],
            [10000, 20000],
        ];

        foreach ($ranges as [$min, $max]) {
            if ($maxPrice >= $min) {
                $prices[] = [
                    'value' => $min . '-' . $max,
                    'label' => $min . ' - ' . $max . ' €',
                ];
            }
        }

        if ($maxPrice > 20000) {
            $prices[] = [
                'value' => '20000+',
                'label' => '20000+ €',
            ];
        }
        // var_dump($colors);
        // die;
        return $this->render('shop.html.twig', [
            'page_title' => 'Shop',
            'categories' => $categories,
            'brands' => $brands,
            'prices' => $prices,
            'colors' => $colors,
            'products' => $products,
            'data' => $products,
            'hasSidebar' => true
        ]);
    }
}
