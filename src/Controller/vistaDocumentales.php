<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class vistaDocumentales extends AbstractController {

    #[Route(path: '/vistaDocumentales', name: 'vistaDocumentales')]
    public function content(): Response {
        return $this->render('pages/vistaDocumentales.html.twig');
    }
}