<?php

namespace App\DataFixtures;

use App\Entity\Task;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
    public function load(ObjectManager $manager): void
    {
        //Tâche sans user
        $task = new Task();
        $task->setCreatedAt(new DateTimeImmutable('now'))
            ->setTitle("Je suis un titre de test en anonyme")
            ->setContent("Je suis un contenu de test en anonyme")
            ->setUser(null);
        $manager->persist($task);

        //Tâche avec user role ADMIN
        $task = new Task();
        $task->setCreatedAt(new DateTimeImmutable('now'))
            ->setTitle("Je suis un contenu de test en admin")
            ->setContent("Je suis un contenu de test en admin")
            ->setUser($this->getReference('user' . "Lucas"));
        $manager->persist($task);

        //Tache avec user role USER
        $task = new Task();
        $task->setCreatedAt(new DateTimeImmutable('now'))
            ->setTitle("Je suis un contenu de test en user")
            ->setContent("Je suis un contenu de test en user")
            ->setUser($this->getReference('user' . "Anaelle"));
        $manager->persist($task);
        $manager->flush();
    }
}
