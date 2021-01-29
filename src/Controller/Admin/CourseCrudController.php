<?php

namespace App\Controller\Admin;

use App\Admin\VideoField;
use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\CodeEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
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
            ->setEntityLabelInSingular('Curso')
            ->setEntityLabelInPlural('Cursos')
            ->setSearchFields(['id', 'name', 'email']);
    }
    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('title');
        $description = TextEditorField::new('description', 'Descripcion');
        $lessons = AssociationField::new('lessons');
       // $ean = TextField::new('ean');
        $price = NumberField::new('price')->addCssClass('text-right');
       // $enabled = BooleanField::new('enabled');
        $createdAt = DateTimeField::new('createdAt');
        //$features = ArrayField::new('features');
        //$tags = ArrayField::new('tags');
        $id = IntegerField::new('id', 'ID');
        $image = ImageField::new('image')->setBasePath('uploads/images/courses');
        $imageFile = ImageField::new('imageFile')->setFormType(VichImageType::class);
        //$video = TextField::new('video')->setTemplatePath('uploads/videos/courses');
        //$videoInput = VideoField::new('video');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $price, $image, $createdAt->setFormat('short', 'short')];
        }

        return [
            FormField::addPanel('Información Básica'),
            $name, $description, $lessons->autocomplete(),
            FormField::addPanel('Detalles'),
            $price, $createdAt,


            FormField::addPanel('Attachments'),
            // TODO: fix this, which doesn't work for some unknown reason
            //$imageFile,
            $imageFile
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
