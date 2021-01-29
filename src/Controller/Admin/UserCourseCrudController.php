<?php

namespace App\Controller\Admin;

use App\Entity\UserCourse;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class UserCourseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserCourse::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Curso y Usuario')
            ->setEntityLabelInPlural('Cursos y Usuarios')
            ->setSearchFields(['id', 'isPayed', 'isAdded']);
    }
    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID');
        $user = AssociationField::new('user', 'Usuario');
        $course = AssociationField::new('course', 'Curso');
        $orders = AssociationField::new('orders', 'Ordenes');
        $isPending= BooleanField::new('isPending', 'Esta Pendiente');
        $isPayed= BooleanField::new('isPayed', 'Esta Pagado');
        $isAdded= BooleanField::new('isAdded', 'Esta Agregado');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $user, $course, $isPending, $isPayed, $isAdded ];
        }

        return [
            FormField::addPanel('Información Básica'),
             $user, $course, $isPending, $isPayed, $isAdded,$orders->autocomplete()

        ];

    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
