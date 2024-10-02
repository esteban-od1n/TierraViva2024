<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class vistaAgregarProductos extends AbstractController {

    #[Route(path: '/vistaAgregarProductos', name: 'vistaAgregarProductos')]
    public function content(): Response {
        return $this->render('pages/vistaAgregarProductos.html.twig');
    }
}