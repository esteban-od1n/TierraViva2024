<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TermCondiciones extends AbstractController {

    #[Route(path: '/TermCondiciones', name: 'TermCondiciones')]
    public function content(): Response {
        return $this->render('pages/TermCondiciones.html.twig');
    }
}