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
                "title" => 'Réparation',
                "text" => "Votre moto a un problème ? L’équipe de MsMotorcycles comprend des professionnels qui résoudront vos soucis en seulement quelques jours !",
                "icon" => 'repair'
            ],
            [
                "title" => 'Vente',
                "text" => "MsMotorcycles vend tout ce dont un vrai motard peut avoir besoin ! Motos, vêtements, accessoires, huiles… Nous avons tout ce qu’il vous faut!",
                "icon" => 'cart'
            ],
            [
                "title" => 'Offres',
                "text" => "En plus de proposer les meilleurs prix du marché, nous offrons occasionnellement des réductions Friends & Family à nos clients !",
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
