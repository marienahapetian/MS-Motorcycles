<?php

namespace App\Controller\Dashboard;

use App\Entity\WebsiteSettings;
use App\Form\SettingsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SettingsController extends AbstractController
{
    #[Route("/dashboard/settings", "dashboard_settings")]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $settings = $doctrine->getRepository(WebsiteSettings::class)->find(1);
        $form = $this->createForm(SettingsType::class, $settings);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($settings);
            $em->flush();
        }
        return $this->render("dashboard/settings.html.twig", ["settings" => $settings, 'form' => $form]);
    }
}
