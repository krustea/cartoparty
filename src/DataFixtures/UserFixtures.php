<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }
    public function load(ObjectManager $manager)
    {

        $admin = new User();
        $admin->setPassword($this->passwordEncoder->encodePassword($admin,'Lennyjasmina35'));
        $admin->setFirstname('thibault');
        $admin->setLastname('tregret');
        $admin->setEmail('thibault.tregret@gmail.com');
        $admin->setAdress('5 rue de la chesnaie');
        $admin->setZipcode('35590');
        $admin->setCity('La Chapelle Thouarault');
        $admin->setPhone('0625111027');
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, '1234'));
        $user->setFirstname('julien');
        $user->setLastname('lecrique');
        $user->setEmail('julien.lecrique@gmail.com');
        $user->setAdress('1 rue de la poupée qui tousse');
        $user->setZipcode('35000');
        $user->setCity('Rennes');
        $user->setPhone('0606060606');
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        $manager->flush();
    }
}
