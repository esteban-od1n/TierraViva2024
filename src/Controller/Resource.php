<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Resource extends AbstractController
{
    #[Route(path: "/resource", name: "resource")]
    public function content(): Response
    {
        return $this->render("pages/resource.html.twig");
    }
}
