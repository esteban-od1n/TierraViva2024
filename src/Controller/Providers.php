<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Providers extends AbstractController {

    #[Route(path: '/providers', name: 'providers')]
    public function content(): Response {
        return $this->render('pages/providers.html.twig');
    }

}
