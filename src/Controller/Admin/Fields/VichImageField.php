<?php


namespace App\Controller\Admin\Fields;


use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VichImageField implements  FieldInterface
{
    use FieldTrait;

    public static  function  new(string $propertyName, ?string $label = null)
    {

        return (new self())
           ->setProperty($propertyName)
           ->setTemplatePath('')
           ->setLabel($label)
            ->setValue('')
           ->setFormType(VichImageType::class);
    }
}