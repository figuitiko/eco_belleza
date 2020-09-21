<?php


namespace App\EventListener;


use App\Security\AppAuthenticator;
use Doctrine\Common\EventSubscriber;

use Doctrine\ORM\Events;
use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class AuthAfterRegister implements EventSubscriber
{


    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(TokenStorageInterface $tokenStorage,
                        SessionInterface $session)
    {


        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist
        ];
    }
    public function postPersist(LifecycleEventArgs $args){
        $this->index($args);
    }
    public function index(LifecycleEventArgs $args){


        $entity= $args->getObject();


        if($entity instanceof User){

        $token = new UsernamePasswordToken($entity, 'null', 'main',$entity->getRoles());
        $this->tokenStorage->setToken($token->getProviderKey(), $token);
        $this->session->set('_security_main', serialize($token));
        }
    }
}