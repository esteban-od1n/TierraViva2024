<?php
namespace App\Controller;

use App\Entity\Providers;
use App\Entity\Topic;
use App\Form\CommentFormType;
use App\Form\PostFormType;
use App\Form\ProviderFormType;
use App\Form\TopicFormType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\ProvidersRepository;
use App\Repository\ResourceRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use \DateTime;

class AdminProviders extends AbstractController
{
    #[Route(path: "/admin/providers", name: "admin_providers")]
    public function providers(
        ProvidersRepository $repo,
        #[MapQueryParameter] ?int $page = 1,
        #[MapQueryParameter] ?string $filter = null
    ): Response {
        if ($page < 1) {
            $page = 1;
        }

        $query = $repo
            ->createQueryBuilder("p")
            ->setMaxResults(21)
            ->setFirstResult(($page - 1) * 21);
        if ($filter) {
            $query
                ->where($query->expr()->like("p.name", ":filter"))
                ->setParameter("filter", "%$filter%");
        }
        $res = $query->getQuery()->getResult();

        return $this->render("admin/providers.html.twig", [
            "providers" => $res,
            "page" => $page,
        ]);
    }

    #[Route(path: "/admin/providers/new", name: "admin_providers_new")]
    public function newProvider(
        ProvidersRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $entity = new Providers();
        $form = $this->createForm(ProviderFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute("admin_providers");
        }

        return $this->render("admin/provider_new.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route(path: "/admin/providers/{id}/edit", name: "admin_provider_edit")]
    public function editProvider(
        int $id,
        ProvidersRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $entity = $repo->find($id);
        if (!$entity) {
            throw new NotFoundHttpException();
        }
        $form = $this->createForm(ProviderFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute("admin_providers");
        }

        return $this->render("admin/provider_edit.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route(path: "/admin/providers/{id}/delete", name: "admin_provider_delete")]
    public function deletePost(
        ProvidersRepository $repo,
        EntityManagerInterface $em,
        int $id,
        #[MapQueryParameter] ?string $action
    ): Response {
        $entity = $repo->find($id);
        if (!$entity) {
            throw new NotFoundHttpException();
        }

        if ($action === "delete") {
            $em->remove($entity);
            $em->flush();
            return $this->redirectToRoute("admin_providers");
        } elseif ($action === "cancelar") {
            return $this->redirectToRoute("admin_providers");
        }

        return $this->render("admin/provider_delete.html.twig", [
            "provider" => $entity,
        ]);
    }
}
