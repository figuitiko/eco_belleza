<?php


namespace App\Services;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\HttpKernel\KernelInterface;

class CourseImageService
{


    private $kernel;

    private $parameterBag;

    private $urlHelper;

    public function __construct(KernelInterface $kernel,ParameterBagInterface $parameterBag, UrlHelper $urlHelper)
    {

        $this->kernel = $kernel;
        $this->parameterBag = $parameterBag;
        $this->urlHelper = $urlHelper;
    }
    function saveToDisk(UploadedFile $image){
        $courseUploadImgDir = $this->parameterBag->get('app.path.course_images');
        $path = $this->kernel->getProjectDir().'/public/'.$courseUploadImgDir;
        $imageName = uniqid() . '.' . $image->guessExtension();
        $image->move($path, $imageName);
        return $this->urlHelper->getAbsoluteUrl('/'). $courseUploadImgDir. '/' . $imageName;
    }
}