<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class vistaNoticias extends AbstractController {

    #[Route(path: '/vistaNoticias', name: 'vistaNoticias')]
    public function content(): Response {
        return $this->render('pages/vistaNoticias.html.twig');
    }
}