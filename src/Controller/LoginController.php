<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        if ($security->getUser()) {
            return $this->redirectToRoute('dashboard_home');
        }
        $u = new User();
        $loginForm = $this->createForm(LoginFormType::class, $u);
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('login/index.html.twig', ['loginForm' => $loginForm, 'error' => $error]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout() {}
}
