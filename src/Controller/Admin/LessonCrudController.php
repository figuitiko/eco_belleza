<?php

namespace App\Controller\Admin;

use App\Entity\Lesson;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class LessonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lesson::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID');
        $title = TextField::new('title');
        $description = TextareaField::new('description');
        $image = ImageField::new('imgUrl')->setBasePath('uploads/images/lessons');
        $imageFile = ImageField::new('imageFile')->setFormType(VichImageType::class);
        $course = AssociationField::new('course');
        $createdAt = DateTimeField::new('createdAt');
        $video = ImageField::new('videoFile')->setFormType(VichFileType::class);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $image, $createdAt->setFormat('short', 'short')];
        }

        return [
            FormField::addPanel('Basic information'),
            $title, $description,$course,
            FormField::addPanel('Product Details'),
             $createdAt,


            FormField::addPanel('Attachments'),
            // TODO: fix this, which doesn't work for some unknown reason
            //$imageFile,
            $imageFile,$video
        ];
    }

}
