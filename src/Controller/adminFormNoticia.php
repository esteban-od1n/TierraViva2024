<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class adminFormNoticia extends AbstractController {

    #[Route(path: '/adminFormNoticia', name: 'adminFormNoticia')]
    public function content(): Response {
        return $this->render('pages/adminFormNoticia.html.twig');
    }
}