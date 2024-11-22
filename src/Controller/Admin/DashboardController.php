<?php

namespace App\Controller\Admin;

use App\Entity\ForumPost;
use App\Entity\ForumComment;
use App\Entity\Provider;
use App\Entity\Product;
use App\Entity\Location;
use App\Entity\Resource;
use App\Entity\ForumTopics;
use App\Entity\ProviderCategories;
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
        yield MenuItem::subMenu("Foro", "fas fa-newspaper")->setSubItems([
            MenuItem::linkToCrud("Posts", "fas fa-newspaper", ForumPost::class),
            MenuItem::linkToCrud("Comentarios", "fas fa-comment", ForumComment::class),
        ]);
        yield MenuItem::subMenu("Proveedores", "fas fa-bell-concierge")->setSubItems([
            MenuItem::linkToCrud("Marcas", "fas fa-bell-concierge", Provider::class),
            MenuItem::linkToCrud("Lugares", "fas fa-map", Location::class),
            MenuItem::linkToCrud("Productos", "fas fa-barcode", Product::class),
        ]);
        yield MenuItem::linkToCrud("Eventos", "fas fa-calendar-days", Events::class);
        yield MenuItem::linkToCrud("Recursos", "fas fa-photo-film", Resource::class);
        yield MenuItem::subMenu("Categorias", "fas fa-bell-tag")->setSubItems([
            MenuItem::linkToCrud("Proveedores", "fas fa-bell-concierge", ForumTopics::class),
            MenuItem::linkToCrud("Foro", "fas fa-newspaper", ProviderCategories::class),
        ]);
    }
}
