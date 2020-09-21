<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Order;
use App\Entity\Question;
use App\Entity\Reply;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //return parent::index();
        $courseList = $this->get(CrudUrlGenerator::class)->build()->setController(CourseCrudController::class)->generateUrl();
        return $this->redirect($courseList);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Eco Belleza New');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Cursos', 'fa fa-home');

        yield MenuItem::linkToCrud('Clases', 'fa fa-book-reader', Lesson::class);
        //yield MenuItem::linkToCrud('Preguntas', 'fa fa-question', Question::class);
        //yield MenuItem::linkToCrud('Respuestas', 'fa fa-reply', Reply::class);
        yield MenuItem::linkToCrud('Ordenes', 'fa fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Usuarios', 'fa fa-user', User::class);

    }
}
