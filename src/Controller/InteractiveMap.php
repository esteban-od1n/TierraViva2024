<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InteractiveMap extends AbstractController {

    #[Route(path: '/mapa', name: 'map')]
    public function content(): Response {
        return $this->render('pages/map.html.twig');
    }

}


