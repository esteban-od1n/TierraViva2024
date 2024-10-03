<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Forum extends AbstractController
{
    #[Route(path: "/foro", name: "foro")]
    public function content(): Response
    {
        return $this->render("pages/foro.html.twig");
    }
}
