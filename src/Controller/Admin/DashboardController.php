<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DemoBlogNew');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('DashBoard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        return [
            MenuItem::linkToDashboard('Accueil', 'fa fa-home'),     // Entrée Menu
            MenuItem::section('Blog', 'fa fa-blog'),                // Entré vers un groupe de Menu
            MenuItem::linkToCrud('Articles', 'fa fa-newspaper', Article::class),
        ];
    }
}
