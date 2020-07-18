<?php


namespace App\Controller\Admin\Fields;


use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VichFileField implements  FieldInterface
{
    use FieldTrait;

    public static  function  new(string $propertyName, ?string $label = null)
    {

        return (new self())
           ->setProperty($propertyName)
           ->setTemplatePath('video.html.twig')
           ->setLabel($label)
            ->setValue('')

           ->setFormType(VichFileType::class);
    }
}