<?php

namespace App\Controller;

use App\Entity\ForumPost;
use App\Form\ForumPostType;
use App\Repository\ForumPostRepository;
use App\Repository\EventsRepository;
use App\Repository\ForumTopicsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Attribute\Route;

class ForumController extends AbstractController
{
    #[Route("/forum", name: "app_forum")]
    public function index(
        ForumPostRepository $repo,
        ForumTopicsRepository $topics_repo,
        EventsRepository $ev_repo
    ): Response {
        return $this->render("forum/index.html.twig", [
            "topics" => $topics_repo->findAll(),
            "posts" => $repo->findAll(),
            "events" => $ev_repo->findAll(),
        ]);
    }

    #[Route("/forum/new", name: "app_forum_new")]
    public function new(Request $req, EntityManagerInterface $em): Response
    {
        $post = new ForumPost();
        $form = $this->createForm(ForumPostType::class, $post);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setPostDate(new DateTime());
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute("app_forum");
        }

        return $this->render("forum/new.html.twig", [
            "postForm" => $form,
        ]);
    }

    #[Route("/forum/{post}", name: "app_forum_post")]
    public function post(ForumPost $post): Response
    {
        return $this->render("forum/post.html.twig", [
            "post" => $post,
            "liked" => $post->getLikes()->contains($this->getUser()),
        ]);
    }

    #[Route("/forum/{post}/like", name: "app_forum_like")]
    public function like(ForumPost $post, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        if ($user == null) {
            throw new UnauthorizedHttpException("NO usuario");
        }

        if ($post->getLikes()->contains($this->getUser())) {
            $post->removeLike($this->getUser());
        } else {
            $post->addLike($this->getUser());
        }

        $manager->persist($post);
        $manager->flush();
        return $this->redirectToRoute("app_forum_post", ["post" => $post->getId()]);
    }
}
