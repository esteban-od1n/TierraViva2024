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

    #[Route(path: "/foro/post/{id}", name: "foro_post")]
    public function post(int $id): Response
    {
        return $this->render("pages/foro.html.twig");
    }
}
