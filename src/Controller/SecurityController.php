<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\RememberMe\RememberMeServicesInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/json_login", name="json_login", methods={"POST"})
     */
    public function jsonLogin(IriConverterInterface $iriConverter, TokenStorageInterface $tokenStorage,
            RememberMeServicesInterface $rememberMeServices, Request $request){

        $user = $this->getUser();
       if($user  instanceof User){

           $response = new JsonResponse( [
               'username' => $user->getUsername(),
               'email'=>$user->getEmail(),
               'roles' => $user->getRoles()

      ] );
           // Capture the JSON Payload posted from the client
           $payload = [];
           if( $request->getContentType() === 'json' ) {
               $payload = json_decode($request->getContent(), true);

               if (json_last_error() !== JSON_ERROR_NONE) {
                   throw new \Exception('Invalid json: ' . json_last_error_msg() );
               }
           }
           // Look for the "_remember_me" form field and cast it to a Boolean
           $rememeberMe = isset($payload['_remember_me'])
               ? filter_var( $payload['_remember_me'], FILTER_VALIDATE_BOOLEAN )
               : false;
           // Set the remember me token
           if( $rememeberMe ){

               $securityToken = $tokenStorage->getToken();

               $rememberMeServices->loginSuccess(
                   $request,
                   $response,
                   $securityToken
               );
           }
       }




        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->json([
                'error'=> 'Invalid login request'
            ], 400);
        }
       return new Response(null, 204, [
           'location'=> $iriConverter->getIriFromItem($this->getUser())
       ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }
}
