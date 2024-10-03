<?php
namespace App\Controller;

use App\Entity\Resource;
use App\Enum\ResourceTypes;
use App\Form\ResourceFormType;
use App\Form\UserFormType;
use App\Repository\ResourceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use \DateTime;

class AdminResources extends AbstractController
{
    #[Route(path: "/admin/resources", name: "admin_resources")]
    public function resouces(
        ResourceRepository $repo,
        #[MapQueryParameter] ?int $page = 1,
        #[MapQueryParameter] ?string $filter = null
    ): Response {
        if ($page < 1) {
            $page = 1;
        }

        $query = $repo
            ->createQueryBuilder("r")
            ->setMaxResults(21)
            ->setFirstResult(($page - 1) * 21);
        if ($filter) {
            $query
                ->where($query->expr()->like("r.name", ":filter"))
                ->setParameter("filter", "%$filter%");
        }
        $resources = $query->getQuery()->getResult();

        return $this->render("admin/resources.html.twig", [
            "resources" => $resources,
            "page" => $page,
        ]);
    }

    #[Route(path: "/admin/resources/new", name: "admin_resources_new")]
    public function addResource(
        ResourceRepository $repo,
        EntityManagerInterface $em,
        #[Autowire("%kernel.project_dir%/public/resources")] string $resDir,
        SluggerInterface $slugger,
        #[MapQueryParameter] ?string $type,
        Request $request
    ): Response {
        $resource = new Resource();
        $form = $this->createForm(ResourceFormType::class, $resource);
        $type = ResourceTypes::tryFrom($type) ?? null;

        if (!empty($type)) {
            $resource->setType($type->value);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $resource->setUploaded(new DateTime());
                $file = $form->get("resourceFile")->getData();
                if (!empty($file)) {
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . "-" . uniqid() . "." . $file->guessExtension();
                    $file->move($resDir, $newFilename);
                    $resource->setUri($newFilename);
                }
                $em->persist($resource);
                $em->flush();
                return $this->redirectToRoute("admin_resources");
            }
        }

        return $this->render("admin/resources_new.html.twig", [
            "resourcesForm" => $form,
            "type" => $type,
            "resourceTypes" => ResourceTypes::cases(),
        ]);
    }

    #[Route(path: "/admin/resources/{id}/edit", name: "admin_resources_edit")]
    public function editResource(
        int $id,
        ResourceRepository $repo,
        EntityManagerInterface $em,
        #[Autowire("%kernel.project_dir%/public/resources")] string $resDir,
        SluggerInterface $slugger,
        Request $request
    ): Response {
        $resource = $repo->find($id);
        if (!$resource) {
            throw NotFoundHttpException;
        }
        $form = $this->createForm(ResourceFormType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get("resourceFile")->getData();
            if (!empty($file)) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . "-" . uniqid() . "." . $file->guessExtension();
                $file->move($resDir, $newFilename);
                $resource->setUri($newFilename);
            }
            $em->persist($resource);
            $em->flush();
            return $this->redirectToRoute("admin_resources");
        }

        return $this->render("admin/resources_edit.html.twig", [
            "resourcesForm" => $form,
            "res" => $resource,
        ]);
    }

    #[Route(path: "/admin/resources/{id}/delete", name: "admin_resources_delete")]
    public function deletRes(
        ResourceRepository $repo,
        EntityManagerInterface $em,
        int $id,
        #[MapQueryParameter] ?string $action
    ): Response {
        $resource = $repo->find($id);
        if (!$resource) {
            throw NotFoundHttpException;
        }

        if ($action === "delete") {
            $em->remove($resource);
            $em->flush();
            return $this->redirectToRoute("admin_resources");
        }

        return $this->render("admin/resources_delete.html.twig", [
            "resource" => $resource,
        ]);
    }
}
