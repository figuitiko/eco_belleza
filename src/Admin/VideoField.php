<?php


namespace App\Admin;


   use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
   use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
   use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
   use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
   use Symfony\Component\Form\Extension\Core\Type\FileType;
   use Symfony\Component\Form\Extension\Core\Type\TextareaType;
   use Symfony\Component\Form\Extension\Core\Type\TextType;


   final class VideoField implements FieldInterface
    {
       use FieldTrait;
           public static function new(string $propertyName, ?string $label = null):self
           {
               return (new self())
                   ->setProperty($propertyName)
                   ->setLabel($label)
                   // this template is used in 'index' and 'detail' pages

                   // this is used in 'edit' and 'new' pages to edit the field contents
                   // you can use your own form types too
                  ->setFormType(TextType::class)
                   ->addCssClass('dropzone')
                   ->setCustomOptions()
                   //->setFormTypeOptions(['data'=>$propertyName])
                 // ->setTemplatePath('admin/field/video.html.twig')
                   //->setFormType(TextareaType::class)
                   //->setCssClass('dropzone')

                   // these methods allow to define the web assets loaded when the
                   // field is displayed in any CRUD page (index/detail/edit/new)
                   //->addCssFiles('js/admin/field-map.css')
                  // ->addJsFiles('js/admin/dropzone-config.js')
                   ;
           }

         /*  public function getAsDto(): FieldDto
           {
               // TODO: Implement getAsDto() method.

              return $this->getAsDto();
           }*/
       }