<?php
namespace App\Controller;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use App\Repository\ResourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use \DateTime;

class AdminForum extends AbstractController
{
    #[Route(path: "/admin/forum", name: "admin_forum")]
    public function forum(
        PostRepository $repo,
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
                ->where($query->expr()->like("p.title", ":filter"))
                ->setParameter("filter", "%$filter%");
        }
        $forum = $query->getQuery()->getResult();

        return $this->render("admin/forum.html.twig", [
            "posts" => $forum,
            "page" => $page,
        ]);
    }

    #[Route(path: "/admin/forum/new", name: "admin_forum_new")]
    public function addPost(
        PostRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setDate(new DateTime());
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute("admin_forum");
        }

        return $this->render("admin/forum_new.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route(path: "/admin/forum/{id}/edit", name: "admin_forum_edit")]
    public function editPost(
        int $id,
        PostRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $post = $repo->find($id);
        if (!$post) {
            throw new NotFoundHttpException();
        }
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute("admin_forum");
        }

        return $this->render("admin/forum_edit.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route(path: "/admin/forum/{id}/delete", name: "admin_forum_delete")]
    public function deletePost(
        PostRepository $repo,
        EntityManagerInterface $em,
        int $id,
        #[MapQueryParameter] ?string $action
    ): Response {
        $post = $repo->find($id);
        if (!$post) {
            throw new NotFoundHttpException();
        }

        if ($action === "delete") {
            $em->remove($post);
            $em->flush();
            return $this->redirectToRoute("admin_forum");
        } elseif ($action === "cancelar") {
            return $this->redirectToRoute("admin_forum");
        }

        return $this->render("admin/forum_delete.html.twig", [
            "post" => $post,
        ]);
    }
}
