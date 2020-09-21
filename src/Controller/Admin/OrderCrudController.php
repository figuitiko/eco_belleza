<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Orden')
            ->setEntityLabelInPlural('Ordenes')
            ->setSearchFields(['id', 'title', 'description','ean', 'image', 'price', 'video']);
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID');
        $isPayPal = BooleanField::new('isPaypal', 'PayPal');
        $isMercadoPago = BooleanField::new('isMercadoPago', 'MercadoPago');
        $isApproved = BooleanField::new('isApproved', 'Aprobado');
        $createdAt = DateTimeField::new('createdAt', 'Creados');
        $price = NumberField::new('price', 'Pago');
        $userCourses = AssociationField::new('usersCourses', 'Cursos')->setCrudController(CourseCrudController::class);
        $user = AssociationField::new('user', 'Usuarios');
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $user,$userCourses, $isPayPal, $isMercadoPago, $isApproved,$price, $createdAt->setFormat('short', 'short')];
        }
        return [
            FormField::addPanel('Basic information'),
            $user->autocomplete(),$isPayPal, $isMercadoPago, $isApproved,
            FormField::addPanel('Product Details'),
            $price, $createdAt,$userCourses->autocomplete()



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
