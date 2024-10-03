<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use \DateTime;

class Forum extends AbstractController
{
    #[Route(path: "/foro", name: "forum")]
    public function content(TopicRepository $trepo, PostRepository $repo): Response
    {
        $posts = $repo->findBy(criteria: [], limit: 21);
        $qbf = $repo
            ->createQueryBuilder("pf")
            ->leftJoin("pf.likes", "l")
            ->groupBy("pf.id")
            ->orderBy("COUNT(l)", "DESC")
            ->setMaxResults(3);
        // $repo->findBy(criteria: [], orderBy: ["likes.count" => "DESC"], limit: 3);
        $qbt = $trepo
            ->createQueryBuilder("t")
            ->leftJoin("t.posts", "p")
            ->groupBy("t.id")
            ->orderBy("COUNT(p)", "DESC")
            ->setMaxResults(5);

        $topics = $qbt->getQuery()->getResult();
        $famous = $qbf->getQuery()->getResult();
        return $this->render("pages/foro.html.twig", [
            "posts" => $posts,
            "topics" => $topics,
            "famous" => $famous,
        ]);
    }

    #[Route(path: "/foro/post/{id}/like", name: "forum_like")]
    public function like(EntityManagerInterface $em, PostRepository $repo, int $id): Response
    {
        $user = $this->getUser();
        /** @var Post */
        $entity = $repo->find($id);
        if (!$entity) {
            throw new NotFoundHttpException();
        }
        if ($entity->getLikes()->contains($user)) {
            $entity->removeLike($this->getUser());
        } else {
            $entity->addLike($this->getUser());
        }
        $em->persist($entity);
        $em->flush();
        return $this->redirectToRoute("forum_post", ["id" => $id]);
    }

    #[Route(path: "/foro/post/{id}", name: "forum_post")]
    public function post(PostRepository $repo, int $id): Response
    {
        /** @var Post */
        $entity = $repo->find($id);
        if (!$entity) {
            throw new NotFoundHttpException();
        }
        return $this->render("pages/post.html.twig", [
            "post" => $entity,
            "liked" => $entity->getLikes()->contains($this->getUser()),
        ]);
    }

    #[Route(path: "/forum/new", name: "forum_new")]
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
            $post->setAuthor($this->getUser());
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute("forum");
        }

        return $this->render("authenticated/forum_new.html.twig", [
            "form" => $form,
        ]);
    }
}
