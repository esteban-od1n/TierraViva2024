<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LocationRepository;
use Symfony\Component\Serializer\SerializerInterface;

class LocationPointsController extends AbstractController
{
    #[Route("/location/points", name: "app_location_points")]
    public function index(LocationRepository $repo): Response
    {
        $points = $repo->findAll();
        return $this->json($points);
    }
}
