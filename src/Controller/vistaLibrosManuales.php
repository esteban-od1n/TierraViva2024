<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class vistaLibrosManuales extends AbstractController {

    #[Route(path: '/vistaLibrosManuales', name: 'vistaLibrosManuales')]
    public function content(): Response {
        return $this->render('pages/vistaLibrosManuales.html.twig');
    }
}