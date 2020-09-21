<?php


namespace App\EventListener;

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserChangedNotifier
{
    // the entity listener methods receive two arguments:
    // the entity instance and the lifecycle event
    public function postPersist(User $user, LifecycleEventArgs $event)
    {
        echo 'i am here'; exit;
        // ... do something to notify the changes
    }
}