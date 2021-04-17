<?php

namespace App\Controller\Admin;

use App\Entity\Lesson;
use App\Form\AttachmentType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
        $description = TextEditorField::new('description');
        $image = ImageField::new('imgUrl')->setBasePath('uploads/images/lessons');
        $imageFile = ImageField::new('imageFile')->setFormType(VichImageType::class);
        $course = AssociationField::new('course', 'Curso');
        $createdAt = DateTimeField::new('createdAt');
        $emBedCode = TextField::new('embedCode','Código del Video');
        $videoPassword = TextField::new('videoPassword','Contraseña de Video');
        $isVisible = BooleanField::new('isVisible','Es visible');

        $attachments = CollectionField::new('attachments', 'Ficheros')
            ->setEntryType(AttachmentType::class)
            ->setFormTypeOption('by_reference', false);


       // $video = ImageField::new('videoFile')->setFormType(VichFileType::class);


        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $createdAt->setFormat('short', 'short'),$course];
        }

        return [
            FormField::addPanel('Basic information'),
            $title, $description,$course, $isVisible, $emBedCode,$videoPassword,
            FormField::addPanel('Product Details'),
             $createdAt,


            FormField::addPanel('Archivos para agregar a la Clase'),
            // TODO: fix this, which doesn't work for some unknown reason
            //$imageFile,

            $attachments
        ];
    }

}
