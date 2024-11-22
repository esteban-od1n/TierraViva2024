<?php

namespace App\Controller;

use App\Enum\ResourceTypes;
use App\Repository\ResourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class ResourcesController extends AbstractController
{
    #[Route("/resources", name: "app_resources")]
    public function index(
        ResourceRepository $repo,
        #[MapQueryParameter] ?string $type = null
    ): Response {
        $query = $repo->createQueryBuilder("resource")->setMaxResults(21);
        if ($type) {
            $enumType = ResourceTypes::tryFrom($type);
            $query
                ->andWhere($query->expr()->eq("resource.type", ":t"))
                ->setParameter(":t", $enumType);
        }
        $result = $query->getQuery()->getResult();
        return $this->render("resources/index.html.twig", [
            "entities" => $result,
        ]);
    }
}
