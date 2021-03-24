<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;

    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new Utilisateur();
        $user->setUsername("usertest");
        $user->setRoles((array)"ROLE_ADMIN");
        $user->setEmail("augustin.d.02@gmail.com");
        $user->setIsVerified(true);

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'nouveaupassword'
        ));

        $manager->persist($user);
        $manager->flush();
    }
}
