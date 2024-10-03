<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Profile extends AbstractController
{
    #[Route(path: "/perfil", name: "profile")]
    public function content(): Response
    {
        return $this->render("pages/profile.html.twig");
    }
}
