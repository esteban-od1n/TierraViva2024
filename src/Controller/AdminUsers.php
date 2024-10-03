<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
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

class AdminUsers extends AbstractController
{
    #[Route(path: "/admin/users", name: "admin_users")]
    public function users(
        UserRepository $userRepo,
        #[MapQueryParameter] ?int $page = 1,
        #[MapQueryParameter] ?string $filter = null
    ): Response {
        if ($page < 1) {
            $page = 1;
        }

        $query = $userRepo
            ->createQueryBuilder("u")
            ->setMaxResults(21)
            ->setFirstResult(($page - 1) * 21);
        if ($filter) {
            $query
                ->where($query->expr()->like("u.email", ":filter"))
                ->orWhere($query->expr()->like("u.name", ":filter"))
                ->setParameter("filter", "%$filter%");
        }
        $users = $query->getQuery()->getResult();

        return $this->render("admin/users.html.twig", [
            "users" => $users,
            "page" => $page,
        ]);
    }

    #[Route(path: "/admin/users/new", name: "admin_users_new")]
    public function newUser(
        UserRepository $userRepo,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $userPasswordHasher,
        #[Autowire("%kernel.project_dir%/public/avatars")] string $avatarDirectory,
        SluggerInterface $slugger,
        Request $request
    ): Response {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwd = $form->get("plainPassword")->getData();
            if (!empty($passwd)) {
                $user->setPassword($userPasswordHasher->hashPassword($user, $passwd));
            }

            $avatar = $form->get("avatarImage")->getData();
            if (!empty($avatar)) {
                $originalFilename = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . "-" . uniqid() . "." . $avatar->guessExtension();
                $avatar->move($avatarDirectory, $newFilename);
                $user->setAvatar($newFilename);
            }
            $user->setVerified(true);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("admin_users");
        }

        return $this->render("admin/users_new.html.twig", [
            "userForm" => $form,
        ]);
    }

    #[Route(path: "/admin/users/{id}/edit", name: "admin_users_edit")]
    public function editUser(
        UserRepository $userRepo,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $userPasswordHasher,
        int $id,
        #[Autowire("%kernel.project_dir%/public/avatars")] string $avatarDirectory,
        SluggerInterface $slugger,
        Request $request
    ): Response {
        $user = $userRepo->find($id);
        if (!$user) {
            throw NotFoundHttpException;
        }
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwd = $form->get("plainPassword")->getData();
            if (!empty($passwd)) {
                $user->setPassword($userPasswordHasher->hashPassword($user, $passwd));
            }

            $avatar = $form->get("avatarImage")->getData();
            if (!empty($avatar)) {
                $originalFilename = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . "-" . uniqid() . "." . $avatar->guessExtension();
                $avatar->move($avatarDirectory, $newFilename);
                $user->setAvatar($newFilename);
            }
            $user->setVerified(true);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("admin_users");
        }

        return $this->render("admin/users_edit.html.twig", [
            "userForm" => $form,
        ]);
    }

    #[Route(path: "/admin/users/{id}/delete", name: "admin_users_delete")]
    public function deleteUser(
        UserRepository $userRepo,
        EntityManagerInterface $em,
        int $id,
        #[MapQueryParameter] ?string $action
    ): Response {
        $user = $userRepo->find($id);
        if (!$user) {
            throw NotFoundHttpException;
        }

        if ($action === "delete") {
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute("admin_users");
        }

        return $this->render("admin/users_delete.html.twig", [
            "user" => $user,
        ]);
    }

    #[Route(path: "/admin/resources", name: "admin_resources")]
    public function resources(): Response
    {
        return $this->render("admin/resources.html.twig");
    }
}
