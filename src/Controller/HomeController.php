<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\WebsiteSettings;
use App\Form\MessageFormType;
use App\Repository\ProductRepository;
use App\Repository\WebsiteSettingsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(Request $request, EntityManagerInterface $entityManager, ProductRepository $pr, WebsiteSettingsRepository $sr): Response
    {
        $services = [
            ["title" => 'Repair', "text" => "Your Bike is having a trouble? MsMotorcycles team includes professionals that will resolve your issues within a matter of days!", "icon" => 'repair'],
            ["title" => 'Sell', "text" => "MsMotorcycles sells everything and anything a Real Biker might need! Bikes, clothing, accessories, oils... We got you covered", "icon" => 'cart'],
            ["title" => 'Offers', "text" => "Apart from having the best prices on the market, we occasionally offer Friends&Family discounts to our customers!", "icon" => 'offers'],

        ];
        $bikes = $pr->getAllByCategory(1, 3); //catId 1, limit 3

        $setting = $sr->find(1);

        $message = new Message();
        $contactForm = $this->createForm(MessageFormType::class, $message);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $message->setSent(new DateTime())->setSeen(false);
            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash('success', 'Message Envoyée!');

            return $this->redirect($this->generateUrl('homepage') . '#contact');
        }

        return $this->render('home.html.twig', [
            'page_title' => 'Home',
            'services' => $services,
            'bikes' => $bikes,
            'contactForm' => $contactForm,
            'settings' => $setting
        ]);
    }
}
