<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\NewProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProviderCategoriesRepository;
use App\Repository\ProductRepository;

class ProvidersController extends AbstractController
{
    #[Route("/providers", name: "app_providers")]
    public function index(
        #[MapQueryParameter] ?string $type = null,
        #[MapQueryParameter] ?string $q = null,
        ProviderCategoriesRepository $cat_repo,
        ProductRepository $prod_repo
    ): Response {
        $categories = $cat_repo->findAll();
        $providerQuery = $prod_repo->createQueryBuilder("p");
        if ($type) {
            $providerQuery->join("p.provider", "prov");
            $providerQuery->join("prov.categories", "cat");
            $providerQuery->andWhere($providerQuery->expr()->eq("cat.name", ":type"));
            $providerQuery->setParameter("type", $type);
        }

        if ($q) {
            $providerQuery->andWhere($providerQuery->expr()->like("p.name", ":search"));
            $providerQuery->setParameter("search", "%$q%");
        }

        $promoted = $prod_repo->findBy([
            "promote" => true,
        ]);
        return $this->render("providers/index.html.twig", [
            "categories" => $categories,
            "products" => $providerQuery->getQuery()->execute(),
            "promoted" => $promoted,
        ]);
    }

    #[Route("/product/new", name: "app_product_new")]
    public function product(Request $req, EntityManagerInterface $em)
    {
        $product = new Product();
        $form = $this->createForm(NewProductType::class, $product);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute("app_providers");
        }
        return $this->render("providers/new-product.html.twig", [
            "form" => $form,
        ]);
    }
}
