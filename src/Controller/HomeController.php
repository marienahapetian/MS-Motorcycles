<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\WebsiteSettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(
        ProductRepository $pr
    ): Response {

        $services = [
            [
                "title" => 'Repair',
                "text" => "Your Bike is having a trouble? MsMotorcycles team includes professionals that will resolve your issues within a matter of days!",
                "icon" => 'repair'
            ],
            [
                "title" => 'Sell',
                "text" => "MsMotorcycles sells everything and anything a Real Biker might need! Bikes, clothing, accessories, oils... We got you covered",
                "icon" => 'cart'
            ],
            [
                "title" => 'Offers',
                "text" => "Apart from having the best prices on the market, we occasionally offer Friends&Family discounts to our customers!",
                "icon" => 'offers'
            ],
        ];

        $bikes = $pr->getAllByCategory(1, 3);

        return $this->render('home.html.twig', [
            'page_title' => 'Home',
            'services' => $services,
            'bikes' => $bikes,
        ]);
    }
}
