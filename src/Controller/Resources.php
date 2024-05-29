<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Resources extends AbstractController {

    #[Route(path: '/recursos', name: 'resources')]
    public function content(): Response {
        return $this->render('pages/resources.html.twig');
    }

}

