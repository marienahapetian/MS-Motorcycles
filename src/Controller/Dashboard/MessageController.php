<?php

namespace App\Controller\Dashboard;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends AbstractController
{
    #[Route("/dashboard/messages", "dashboard_messages")]
    public function list(EntityManagerInterface $em, Request $request): Response
    {
        $messages = $em->getRepository(Message::class)->findAllMessages($request->query->getInt('page', 1));

        return $this->render("dashboard/message/list.html.twig", [
            'msgs' => $messages,
            'data' => $messages
        ]);
    }

    #[Route("/dashboard/message/{id}", "dashboard_message_view")]
    public function view(Message $message, EntityManagerInterface $entityManager): Response
    {
        if (!$message->isSeen()) {
            $message->setSeen(true);
            $entityManager->persist($message);
            $entityManager->flush();
        }
        return $this->render("dashboard/message/view.html.twig", [
            "message" => $message
        ]);
    }
}
