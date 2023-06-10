<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordhasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
       $contributor = new User();
       $contributor->setEmail("contributor@monsite.com");
       $contributor->setRoles(['ROLE_CONTRIBUTOR']);
       $hashedPassword = $this->passwordhasher->hashPassword(
           $contributor,
           'contributorpassword'
       );
       $contributor->setPassword($hashedPassword);
       $manager->persist($contributor);

       $admin = new User();
       $admin->setEmail('admin@monsite.com');
       $admin->setRoles(['ROLE_ADMIN']);
       $hashedPassword = $this->passwordhasher->hashPassword(
           $admin,
       'adminpassword');
       $admin->setPassword($hashedPassword);
       $manager->persist($admin);

       $manager->flush();

        $manager->flush();
    }
}
