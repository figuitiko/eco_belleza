<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Question;
use App\Entity\Reply;
use App\Entity\Test;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
      //  return parent::index();

        // redirect to some CRUD controller
   $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
       return $this->redirect($routeBuilder->setController(CourseCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Eco Belleza Administración')
                ->setTranslationDomain('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home')->setCssClass('sidebar-brand d-flex align-items-center justify-content-center');

        yield MenuItem::linkToCrud('Cursos', 'fa fa-graduation-cap', Course::class)
            ->setCssClass('sidebar-brand d-flex align-items-center justify-content-center');
        yield MenuItem::linkToCrud('Lecciones', 'fa fa-chalkboard-teacher', Lesson::class)
                ->setCssClass('sidebar-brand d-flex align-items-center justify-content-center');

        yield MenuItem::linkToCrud('Test', 'fa fa-book-open', Test::class)
                        ->setCssClass('sidebar-brand d-flex align-items-center justify-content-center');
        yield MenuItem::linkToCrud('Preguntas', 'fa fa-question', Question::class)
                         ->setCssClass('sidebar-brand d-flex align-items-center justify-content-center');
        yield MenuItem::linkToCrud('Respuestas', 'fa fa-reply', Reply::class)
                        ->setCssClass('sidebar-brand d-flex align-items-center justify-content-center');
        yield MenuItem::linkToCrud('Usuario', 'fa fa-user', User::class)
                        ->setCssClass('sidebar-brand d-flex align-items-center justify-content-center')
                        ->setController(UserCrudController::class);
        yield MenuItem::linkToLogout('Salir', 'fa fa-exit')
                        ->setCssClass('sidebar-brand d-flex align-items-center justify-content-center');

        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
    }
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(false)

            // you can return an URL with the avatar image
            ->setAvatarUrl('https://...')
           // ->setAvatarUrl($user->getProfileImageUrl())
            // use this method if you don't want to display the user image
            ->displayUserAvatar(false)
            // you can also pass an email address to use gravatar's service
            ->setGravatarEmail($user->getEmail())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
               // MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
              //  MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }
}
