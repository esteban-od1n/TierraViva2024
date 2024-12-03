<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProviderCategoriesRepository;
use App\Repository\ProviderRepository;
use App\Repository\ProductRepository;

class ProvidersController extends AbstractController
{
    #[Route("/providers", name: "app_providers")]
    public function index(
        #[MapQueryParameter] ?string $type = null,
        ProviderCategoriesRepository $cat_repo,
        ProductRepository $prod_repo
    ): Response {
        $categories = $cat_repo->findAll();
        $providerQuery = $prod_repo->createQueryBuilder("p");
        $providerQuery;
        if ($type) {
            $providerQuery->andWhere(
                $providerQuery->expr()->eq("p.provider.categories.name", $type)
            );
        }

        return $this->render("providers/index.html.twig", [
            "categories" => $categories,
            "products" => $providerQuery->getQuery()->execute(),
        ]);
    }
}
