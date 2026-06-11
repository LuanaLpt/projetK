<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)  {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin -> setEmail('admin@test.fr');
        $admin -> setRoles(['ROLE_ADMIN']);

        $admin->setPassword(
            $this->userPasswordHasher->hashPassword($admin, 'test')
        );




$manager ->persist($admin);
        $manager->flush();
    }
}
