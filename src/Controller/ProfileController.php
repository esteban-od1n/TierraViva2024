<?php

namespace App\Controller;

use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route("/profile", name: "app_profile")]
    public function index(): Response
    {
        return $this->render("profile/index.html.twig");
    }

    #[Route("/profile/edit", name: "app_profile_edit")]
    public function edit(Request $request): Response
    {
        $form = $this->createForm(ProfileType::class);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render("profile/edit.html.twig", [
                "form" => $form,
            ]);
        }

        $test = $form->getData();
        dd($test);
    }
}
