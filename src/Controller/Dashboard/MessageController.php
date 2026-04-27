<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends AbstractController
{
    #[Route("/dashboard/messages", "dashboard_messages")]
    public function list(): Response
    {
        $messages = [
            ["id" => 1, "sentBy" => "Jane Doe", "email" => "mk123@test.com", "subject" => "purchase", "message" => "I want to...", "recieved" => "2026-03-28 10:15"],
            ["id" => 2, "sentBy" => "Jack Doe", "email" => "mk123@test.com", "subject" => "refund", "message" => "I need a refund..", "recieved" => "2026-03-28 12:17"],
            ["id" => 3, "sentBy" => "Anne Black", "email" => "mk123@test.com", "subject" => "purchase", "message" => "I want to...", "recieved" => "2026-03-28 10:00"],
            ["id" => 4, "sentBy" => "Mary Kate", "email" => "mk123@test.com", "subject" => "refund", "message" => "I need a refund..", "recieved" => "2026-03-27 23:10"],
            ["id" => 5, "sentBy" => "John Doe", "email" => "mk123@test.com", "subject" => "tracking", "message" => "Where is my order?", "recieved" => "2026-03-27 18:15"],
            ["id" => 6, "sentBy" => "Jane Doe", "email" => "mk123@test.com", "subject" => "tracking", "message" => "Where is my order?", "recieved" => "2026-03-26 15:00"],
        ];
        $currentPage = 1;
        $totalPages = 5;
        return $this->render("dashboard/messages.html.twig", [
            'msgs' => $messages,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route("/dashboard/message/{id}", "dashboard_message_view")]
    public function view(): Response
    {
        $message = ["id" => 1, "sentBy" => "Jane Doe", "email" => "mk123@test.com", "subject" => "purchase", "message" => "I want to...", "recieved" => "2026-03-28 10:15"];

        return $this->render("dashboard/message/view.html.twig", [
            "message" => $message
        ]);
    }
}
