<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SettingsController extends AbstractController
{
    #[Route("/dashboard/settings", "dashboard_settings")]
    public function index(): Response
    {
        $settings = [
            "font_family" => "Hanken Grotesk",
            "instagram" => "msmotorcycles",
            "twitter" => "msmotorcycles",
            "tiktok" => "msmotorcycles",
            "email" => "msmotorcycles@gmail.com",
            "address" => "4 Rue Bernard Palissy, 64230 Lescar",
            "phone" => "0668457549",
            "accent_color" => "#DB362C",
            "black_color" => "#323232",
            "white_color" => "#FFFFFF",
            "google_map" => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2902.674750591449!2d-0.435683824457153!3d43.321067671119714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd564f06a4058d01%3A0x5f23de009965d82b!2sMs%20Motorcycles!5e0!3m2!1sen!2sfr!4v1775683633324!5m2!1sen!2sfr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
        ];
        return $this->render("dashboard/settings.html.twig", ["settings" => $settings]);
    }
}
