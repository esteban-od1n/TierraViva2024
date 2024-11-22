<?php

namespace App\Controller\Admin;

use App\Entity\ForumPost;
use App\Entity\ForumComment;
use App\Entity\Provider;
use App\Entity\Product;
use App\Entity\Events;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route("/admin", name: "admin")]
    public function index(): Response
    {
        return $this->render("admin/dashboard.html.twig");
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle("TierraViva");
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud("Usuarios", "fas fa-user", User::class);
        yield MenuItem::linkToCrud("Foro", "fas fa-newspaper", ForumPost::class);
        yield MenuItem::linkToCrud("Comentarios", "fas fa-comment", ForumComment::class);
        yield MenuItem::linkToCrud("Proveedores", "fas fa-bell-concierge", Provider::class);
        yield MenuItem::linkToCrud("Productos", "fas fa-barcode", Product::class);
        yield MenuItem::linkToCrud("Eventos", "fas fa-calendar-days", Events::class);
    }
}
