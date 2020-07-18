<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{


    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {

        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $roles = ['ROLE_ADMIN'];
        //$roles = json_encode($roles, true);

        $user = New User();
        $password = $this->userPasswordEncoder->encodePassword($user,'zaq123');
        $user->setEmail('eco-belleza@ecobelleza.com');
        $user->setName('EcoBelleza');
        $user->setRoles($roles);
        $user->setPassword($password);
        $manager->persist($user);

        $manager->flush();
    }
}
