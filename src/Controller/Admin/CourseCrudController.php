<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Fields\VichImageField;
use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Cursos')
            ->setEntityLabelInPlural('Cursos')
            ->setSearchFields(['id', 'title', 'description', 'image']);
    }

    public function configureFields(string $pageName): iterable
    {
         $imgUrl = $this->getParameter('app.path.course_images');

        $id = IntegerField::new('id', 'ID');
         $title = TextField::new('title','Título');
         $description =  TextEditorField::new('description','Descripción');
         $image = ImageField::new('image')->setBasePath($imgUrl);
         $lessons = AssociationField::new('lessons');
         $imageFile = VichImageField::new('imageFile');
            if (Crud::PAGE_INDEX === $pageName) {
                return [$id, $title,$description ,$image];
            }

         return [
             FormField::addPanel('Información Basica'),
             $title, $description,$lessons,
             FormField::addPanel('Abjuntos'),
             $imageFile
         ];

    }

}
