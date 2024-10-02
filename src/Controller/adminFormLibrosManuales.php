<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class adminFormLibrosManuales extends AbstractController {

    #[Route(path: '/adminFormLibrosManuales', name: 'adminFormLibrosManuales')]
    public function content(): Response {
        return $this->render('pages/adminFormLibrosManuales.html.twig');
    }
}