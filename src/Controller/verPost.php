<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class verPost extends AbstractController {

    #[Route(path: '/verPost', name: 'verPost')]
    public function content(): Response {
        return $this->render('pages/verPost.html.twig');
    }
}