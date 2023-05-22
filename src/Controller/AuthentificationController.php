<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthentificationController extends AbstractController
{
    #[Route('/authentification', name: 'app_authentification')]
    public function index(): Response
    {
        return $this->json("{\"message\": \"url not found\"}");
    }

    #[Route('/authentification/login', name: 'app_login', methods: ['POST'])]
    public function login()
    {
    }
}
