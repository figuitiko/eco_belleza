<?php


namespace App\Controller;

use  App\Entity\ContactData;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class SendContactEmail
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(\Swift_Mailer $mailer ,ParameterBagInterface $parameterBag, ContainerInterface $container)
    {
        $this->mailer = $mailer;
        $this->parameterBag = $parameterBag;
        $this->container = $container;
    }
    public function __invoke(ContactData $data)
    {
        $emailSender = $this->parameterBag->get('mail_owner');

        $message = (new \Swift_Message('Eco Belleza'))
            ->setFrom($emailSender)
            ->setTo( $data->getEmail())
            ->setBody(

                  $this->container->get('twig')->render('emails/contact.html.twig')
            );
        $this->mailer->send($message);

        return $data;
    }
}