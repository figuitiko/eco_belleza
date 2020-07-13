<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Entity\Lesson;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LessonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lesson::class;
    }


    public function configureFields(string $pageName): iterable
    {

        return [

            TextField::new('title'),
            TextEditorField::new('description'),
            AssociationField::new('course')
        ];
    }

}
