<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    private $utils;

    public function __construct(AuthenticationUtils $utils)
    {
        $this->utils = $utils;
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function loginAction(): Response
    {
        $error = $this->utils->getLastAuthenticationError();
        $lastUsername = $this->utils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        // This code is never executed.
    }
}
