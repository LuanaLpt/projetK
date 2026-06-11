<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)  {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user -> setEmail('user@test.fr');
        $user -> setRoles(['ROLE_USER']);

        $user->setPassword(
            $this->userPasswordHasher->hashPassword($user, 'test')
        );




        $manager ->persist($user);
        $manager->flush();
    }
}
