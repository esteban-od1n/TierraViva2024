<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentFormType;
use App\Form\PostFormType;
use App\Repository\CommentRepository;
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

    #[Route(path: "/admin/forum/comments", name: "admin_forum_comments")]
    public function forumComments(
        CommentRepository $repo,
        #[MapQueryParameter] ?int $page = 1
    ): Response {
        if ($page < 1) {
            $page = 1;
        }

        $query = $repo
            ->createQueryBuilder("c")
            ->setMaxResults(21)
            ->setFirstResult(($page - 1) * 21);
        $comments = $query->getQuery()->getResult();

        return $this->render("admin/forum_comments.html.twig", [
            "comments" => $comments,
            "page" => $page,
        ]);
    }

    #[Route(path: "/admin/forum/comments/new", name: "admin_forum_comments_new")]
    public function forumCommentsNew(
        CommentRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $entity = new Comment();
        $form = $this->createForm(CommentFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute("admin_forum_comments");
        }

        return $this->render("admin/forum_comment_new.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route(path: "/admin/forum/comments/{id}/edit", name: "admin_forum_comments_edit")]
    public function forumCommentsEdit(
        int $id,
        CommentRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $entity = $repo->find($id);
        if (empty($entity)) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(CommentFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute("admin_forum_comments");
        }

        return $this->render("admin/forum_comment_edit.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route(path: "/admin/forum/comments/{id}/delete", name: "admin_forum_comments_delete")]
    public function deletComment(
        int $id,
        CommentRepository $repo,
        EntityManagerInterface $em,
        #[MapQueryParameter] ?string $action
    ): Response {
        $entity = $repo->find($id);
        if (empty($entity)) {
            throw new NotFoundHttpException();
        }

        if ($action === "delete") {
            $em->remove($entity);
            $em->flush();
            return $this->redirectToRoute("admin_forum_comments");
        } elseif ($action === "cancelar") {
            return $this->redirectToRoute("admin_forum_comments");
        }

        return $this->render("admin/forum_comment_delete.html.twig", [
            "comment" => $entity,
        ]);
    }

    #[Route(path: "/admin/forum/new", name: "admin_forum_new")]
    public function addPost(
        ResourceRepository $repo,
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
