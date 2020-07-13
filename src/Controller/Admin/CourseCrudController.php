<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Fields\VichImageField;
use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CourseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Course::class;
    }


    public function configureFields(string $pageName): iterable
    {
         $imgUrl = $this->getParameter('app.path.course_images');

        return [

            TextField::new('title','Título'),

            TextEditorField::new('description'),
            ImageField::new('image','Imagen')->setFormTypeOption('data_class', null),
           //VichImageField::new('imageFile', 'Subir Imagen')->hideOnIndex()

        ];
    }

}
