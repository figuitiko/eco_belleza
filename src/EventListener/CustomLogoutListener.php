<?php


namespace App\EventListener;







use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Security\Http\Event\LogoutEvent;


class CustomLogoutListener implements EventSubscriberInterface
{

    
    public static function getSubscribedEvents()
    {

        return [
            LogoutEvent::class=>'logOutSuccess'
        ];
    }
    public function logOutSuccess(){


        return new JsonResponse(["success" => true]);
    }
}