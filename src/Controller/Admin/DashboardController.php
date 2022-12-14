<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;
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
            MenuItem::linkToCrud('Catégories', 'fa fa-newspaper', Category::class),
            MenuItem::section('Commentaires', 'fa fa-comments'),                // Entré vers un groupe de Menu
            MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Comment::class),
            MenuItem::section('Membres', 'fa fa-users'),                // Entré vers un groupe de Menu
            MenuItem::linkToCrud('Utilisateur', 'fa fa-user', User::class),
        ];
    }
}
