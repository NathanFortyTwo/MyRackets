<?php

namespace App\Controller\Admin;

use App\Entity\DisplayRack;
use App\Entity\Inventory;
use App\Entity\Racket;
use App\Entity\TennisMan;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
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
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(InventoryCrudController::class)->generateUrl());
        //return $this->redirect($routeBuilder->setController(RacketCrudController::class)->generateUrl());
        //return $this->redirect($routeBuilder->setController(TennisManCrudController::class)->generateUrl());
        //return $this->redirect($routeBuilder->setController(DisplayRackCrudController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        return $this->render('some/path/my-dashboard.html.twig');
    }




    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MyRackets');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Inventory', 'fas fa-list', Inventory::class);
        yield MenuItem::linkToCrud('Racket', 'fas fa-bold', Racket::class);
        yield MenuItem::linkToCrud('TennisMan', 'fas fa-bold', TennisMan::class);
        yield MenuItem::linkToCrud('Galleries', 'fas fa-camera', DisplayRack::class);
        yield MenuItem::linkToRoute('Back to site', 'fas fa-arrow-left', "app_inventory");
    }
}
