<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Topic;
use App\Form\CommentFormType;
use App\Form\PostFormType;
use App\Form\TopicFormType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
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

class AdminTopics extends AbstractController
{
    #[Route(path: "/admin/topics", name: "admin_topics")]
    public function topics(
        TopicRepository $repo,
        #[MapQueryParameter] ?int $page = 1,
        #[MapQueryParameter] ?string $filter = null
    ): Response {
        if ($page < 1) {
            $page = 1;
        }

        $query = $repo
            ->createQueryBuilder("t")
            ->setMaxResults(21)
            ->setFirstResult(($page - 1) * 21);
        if ($filter) {
            $query
                ->where($query->expr()->like("t.name", ":filter"))
                ->setParameter("filter", "%$filter%");
        }
        $res = $query->getQuery()->getResult();

        return $this->render("admin/topics.html.twig", [
            "topics" => $res,
            "page" => $page,
        ]);
    }

    #[Route(path: "/admin/topics/new", name: "admin_topics_new")]
    public function newTopic(
        TopicRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $entity = new Topic();
        $form = $this->createForm(TopicFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute("admin_topics");
        }

        return $this->render("admin/topic_new.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route(path: "/admin/topics/{id}/edit", name: "admin_topic_edit")]
    public function editTopic(
        int $id,
        TopicRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $entity = $repo->find($id);
        if (!$entity) {
            throw new NotFoundHttpException();
        }
        $form = $this->createForm(TopicFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute("admin_topics");
        }

        return $this->render("admin/topic_edit.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route(path: "/admin/topics/{id}/delete", name: "admin_topic_delete")]
    public function deletePost(
        TopicRepository $repo,
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
            return $this->redirectToRoute("admin_topics");
        } elseif ($action === "cancelar") {
            return $this->redirectToRoute("admin_topics");
        }

        return $this->render("admin/topic_delete.html.twig", [
            "topic" => $entity,
        ]);
    }
}
