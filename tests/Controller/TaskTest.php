<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TasktTest extends WebTestCase
{
    private function createLoginForTest()
    {
        $client = $this->createClient();
        $userRepository =  $this->getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('lucas.greard07@gmail.com');

        // simulate $testUser being logged in
        return $client->loginUser($testUser);
    }
    public function testTaskPageIsUp()
    {
        $client = $this->createLoginForTest();

        $client->request('GET', '/task');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('footer', 'Copyright');
    }
    // public function testTaskNew()
    // {
    //     $client = $this->createLoginForTest();
    //     $client->followRedirects();
    //     $crawler = $client->request('GET', '/task/new');
    //     $form = $crawler->selectButton('Save')->form();

    //     $title = $form['task[title]']->setValue('Jesuisuntest');
    //     $form['task[_token]']->setValue('Je suis un test');

    //     $client->submit($form);
    //     $crawler = $client->followRedirects();
    //     $taskRepository = static::getContainer()->get(TaskRepository::class);
    //     $testTask = $taskRepository->findBy(["title" => $title]);
    //     dd($testTask);
    //     $this->assertEquals('anaelleoury40@gmail.com', $testTask->getEmail());
    //     $this->assertResponseIsSuccessful();
    // }
    // public function testTaskShow(ManagerRegistry $doctrine)
    // {
    //     $client = $this->createLoginForTest();
    //     $userRepository =  $this->getContainer()->get(UserRepository::class);

    //     // retrieve the test user
    //     $testUser = $userRepository->findOneByEmail('lucas.greard07@gmail.com');

    //     $task = new Task();
    //     $task->setContent("Je suis un test")
    //         ->setCreatedAt(new DateTimeImmutable('now'))
    //         ->setTitle("Je suis un titre de test")
    //         ->setIsDone(1)
    //         ->setUser($testUser);

    //     $entityManager = $doctrine->getManager();
    //     $entityManager->persist($task);
    //     $entityManager->flush();
    //     $client->request('GET', '/user/' . $testUser->getId());
    //     $this->assertResponseIsSuccessful();
    // }
    // public function testTaskEdit()
    // {
    //     $client = $this->createLoginForTest();
    //     $client->followRedirects();
    //     $crawler = $client->request('GET', '/task/3/edit');

    //     $this->assertResponseIsSuccessful();

    //     $form = $crawler->selectButton('Update')->form();

    //     $form['task[title]']->setValue('Je test');
    //     $form['task[content]']->setValue('Je test 2');

    //     $client->submit($form);
    // }
    // public function testTaskDelete()
    // {
    // }
}
