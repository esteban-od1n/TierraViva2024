<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Index extends AbstractController {

    #[Route(path: '/', name: 'index')]
    public function content(): Response {
        return $this->render('pages/index.html.twig');
    }



    
}
