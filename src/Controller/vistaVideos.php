<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class vistaVideos extends AbstractController {

    #[Route(path: '/vistaVideos', name: 'vistaVideos')]
    public function content(): Response {
        return $this->render('pages/vistaVideos.html.twig');
    }
}