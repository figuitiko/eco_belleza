<?php


namespace App\Subscriber;


use App\Entity\Course;
use App\Services\CourseImageService;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class PostCourseImageSubscriber implements  EventSubscriberInterface
{



    private $courseImageService;

    public function __construct(CourseImageService $courseImageService)
    {
        $this->courseImageService = $courseImageService;
    }

    public static function getSubscribedEvents()
    {
        return array(
           BeforeEntityPersistedEvent::class => array('postImage'),
            BeforeEntityUpdatedEvent::class =>array('postUpdateImage')
        );
    }
    public function postImage(BeforeEntityPersistedEvent $event)
    {
        $result = $event->getEntityInstance();




        if (! $result instanceof Course ) {
            return;
        }

        if ($result->getImage() instanceof UploadedFile) {
            $url = $this->courseImageService->saveToDisk($result->getImage());
            $result->setImage($url);
        }
    }
    public function postUpdateImage(BeforeEntityUpdatedEvent $event)
    {
        $result = $event->getEntityInstance();




        if (! $result instanceof Course ) {
            return;
        }

        if ($result->getImage() instanceof UploadedFile) {
            $url = $this->courseImageService->saveToDisk($result->getImage());
            $result->setImage($url);
        }
    }

}