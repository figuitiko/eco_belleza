<?php

namespace App\Controller\Admin;

use App\Entity\ContactData;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactDataCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContactData::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Contacto')
            ->setEntityLabelInPlural('Contactos')
            ->setSearchFields(['id', 'name', 'email', 'createdAt']);
    }


    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID');
        $name = TextField::new('name');
        $email = EmailField::new('email');
        $msg = TextareaField::new('msg');
        $createdAt = DateTimeField::new('createdAt');
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $email, $createdAt->setFormat('short', 'short')];
        }


        return [
            FormField::addPanel('Información Básica'),
            $name, $email,$msg,$createdAt

        ];
    }

}
