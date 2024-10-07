<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class adminFormDocumentales extends AbstractController {

    #[Route(path: '/adminFormDocumentales', name: 'adminFormDocumentales')]
    public function content(): Response {
        return $this->render('pages/adminFormDocumentales.html.twig');
    }
}