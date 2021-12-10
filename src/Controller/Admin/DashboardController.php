<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\StaticPage;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(ArticleCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Blog pron1mo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Панель управления', 'fa fa-home');
        yield MenuItem::linkToCrud('Статьи', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Теги', 'fas fa-tags', Tag::class);
        if ($this->isGranted('ROLE_ADMIN')){
            yield MenuItem::linkToCrud('Статические страницы', 'fas fa-clone', StaticPage::class);
        }
    }
}
