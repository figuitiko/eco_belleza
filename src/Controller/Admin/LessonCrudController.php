<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Fields\VichFileField;
use App\Controller\Admin\Fields\VichImageField;
use App\Controller\Admin\Fields\VichVideoField;
use App\Entity\Course;
use App\Entity\Lesson;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LessonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lesson::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Leccion')
            ->setEntityLabelInPlural('Lecciones')
            ->setSearchFields(['id', 'title', 'description', 'image']);
    }
    public function configureFields(string $pageName): iterable
    {
        $videoUrl = $this->getParameter('app.path.lessons_videos');

        $id = IntegerField::new('id', 'ID');
        $title = TextField::new('title', 'Titulo');
        $course =  AssociationField::new('course','Curso');
        $description = TextEditorField::new('description','Descripción');
        $videoUrl = ImageField::new('videoUrl', 'Video');
        $videoFile = VichFileField::new('videoFile');
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title,$description];
        }

        return [
            FormField::addPanel('Información Basica'),
            $title,$description,$course,
            FormField::addPanel('Abjuntos'),
            $videoFile

        ];
    }

}
