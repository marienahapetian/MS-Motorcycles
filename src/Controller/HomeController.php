<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $services = [
            ["title" => 'Repair', "text" => "Your Bike is having a trouble? MsMotorcycles team includes professionals that will resolve your issues within a matter of days!", "icon" => 'repair'],
            ["title" => 'Sell', "text" => "MsMotorcycles sells everything and anything a Real Biker might need! Bikes, clothing, accessories, oils... We got you covered", "icon" => 'cart'],
            ["title" => 'Offers', "text" => "Apart from having the best prices on the market, we occasionally offer Friends&Family discounts to our customers!", "icon" => 'offers'],

        ];
        $bikes = [
            ["name" => 'Harley Davidson', "desc" => "The Star of bikes, lorem ipsum dolor sit amet", "image" => 'uploads/9662854e-45ef-4fee-9be0-4fbbfe774be4.jpg'],
            ["name" => 'Kawasaki Ninja', "desc" => "The Star of bikes, lorem ipsum dolor sit amet", "image" => 'uploads/carlos-unique-beitragsbild-545x364.jpg.pagespeed.ce.7i8a8sDMzQ.jpg'],
            ["name" => 'Harley Davidson', "desc" => "The Star of bikes, lorem ipsum dolor sit amet", "image" => 'uploads/S0-harley-davidson-prepare-un-nouveau-custom-pour-2021-186722.jpg'],

        ];

        return $this->render('home.html.twig', [
            'page_title' => 'Home',
            'services' => $services,
            'bikes' => $bikes
        ]);
    }
}
