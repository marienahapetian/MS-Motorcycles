<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard_home')]
    public function dashboard(): Response
    {
        return $this->render('dashboard/main.html.twig', [
            'totalProducts' => 10,
            'totalCategories' => 5,
            'totalMessages' => 150,
            'totalVisits' => 12450,
            'visitsPerMonth' => [12, 19, 8, 15, 22, 30],
        ]);
    }
}
