<?php


namespace App\EventListener;


use App\Security\AppAuthenticator;
use Doctrine\Common\EventSubscriber;

use Doctrine\ORM\Events;
use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    public function __construct(TokenStorageInterface $tokenStorage,
                        SessionInterface $session, \Swift_Mailer $mailer, ContainerInterface $container,
                                ParameterBagInterface $parameterBag  )
    {


        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->mailer = $mailer;
        $this->container = $container;
        $this->parameterBag = $parameterBag;
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


        if(!$entity instanceof User){
            return;
        }

        $token = new UsernamePasswordToken($entity, 'null', 'main',$entity->getRoles());
        $this->tokenStorage->setToken($token->getProviderKey(), $token);
        $this->session->set('_security_main', serialize($token));
        $emailSender = $this->parameterBag->get('mail_owner');

        $message = (new \Swift_Message('Registro'))
            ->setFrom($emailSender)
            ->setTo($entity->getEmail())
            ->setBody(
                $this->container->get('twig')->render('emails/registration.html.twig', ['user'=>$entity])

            );
        $this->mailer->send($message);
    }
}