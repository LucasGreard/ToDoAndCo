<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //user Role ADMIN
        $pseudo = "Lucas";
        $userPasswordHasher = password_hash("Test50", CRYPT_BLOWFISH);
        $user = new User();
        $user->setEmail('lucas.greard07@gmail.com')
            ->setPassword(
                $userPasswordHasher
            )
            ->setPseudo($pseudo)
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $this->addReference('user' . $pseudo, $user);

        //User ROLE User
        $pseudo = "Anaelle";
        $userPasswordHasher = password_hash("Test50", CRYPT_BLOWFISH);
        $user = new User();
        $user->setEmail('anaelleoury@gmail.com')
            ->setPassword(
                $userPasswordHasher
            )
            ->setPseudo('Anaelle')
            ->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();
        $this->addReference('user' . $pseudo, $user);
    }
}
