<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class profile extends AbstractController {

    #[Route(path: '/profile', name: 'profile')]
    public function content(): Response {
        return $this->render('pages/profile.html.twig');
    }

}
