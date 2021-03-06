<?php

namespace App\Tests\Controller;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TasktTest extends WebTestCase
{
    private function createUser()
    {
        return [
            "email" => "lucas.greard07@gmail.com"
        ];
    }
    private function createTask()
    {
        return [
            "title" => "Je suis un test",
            "content" => "Je suis un contenu de test",
            "user_id" => 2
        ];
    }
    private function createTaskEdit()
    {
        $task = $this->createTask();
        $taskReplacements = ['title' => "Je suis un nouveau test"];
        return array_replace($task, $taskReplacements);
    }
    private function createLoginForTest()
    {
        $client = $this->createClient();
        $user = $this->createUser();
        $userRepository =  $this->getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail($user['email']);
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
    public function testTaskNew()
    {
        $client = $this->createLoginForTest();
        $client->followRedirects();
        $crawler = $client->request('GET', '/task/new');

        $task = $this->createTask();

        $form = $crawler->selectButton('Save')->form();
        $form['task[title]']->setValue($task['title']);
        $form['task[content]']->setValue($task['content']);
        $client->submit($form);

        $crawler = $client->followRedirects();
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneBy(["title" => $task['title']]);

        $user = $this->createUser();
        $this->assertEquals($user['email'], $testTask->getUser()->getEmail());
        $this->assertResponseIsSuccessful();
    }
    public function testTaskShow()
    {
        $client = $this->createLoginForTest();

        $client->followRedirects();
        $task = $this->createTask();
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneBy(["title" => $task['title']]);

        $client->request('GET', '/task/' . $testTask->getId());
        $this->assertSelectorTextContains('table', $task['title']);
        $this->assertResponseIsSuccessful('200');
    }
    public function testTaskEdit()
    {
        $client = $this->createLoginForTest();
        $client->followRedirects();

        $task = $this->createTask();
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneBy(["title" => $task['title']]);

        $crawler = $client->request('GET', '/task/' . $testTask->getId() . '/edit');

        $this->assertResponseIsSuccessful();
        $this->assertInputValueSame('task[title]', $task['title']);
    }
    public function testTaskEditIsSubmit()
    {
        $client = $this->createLoginForTest();
        $client->followRedirects();

        $task = $this->createTask();
        $taskEdit = $this->createTaskEdit();
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneBy(["title" => $task['title']]);

        $crawler = $client->request('GET', '/task/' . $testTask->getId() . '/edit');

        $form = $crawler->selectButton('Update')->form();
        $taskReplace = $this->createTaskEdit();
        $form['task[title]']->setValue($taskReplace['title']);
        $form['task[content]']->setValue($taskReplace['content']);

        $client->submit($form);

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneBy(["title" => $taskReplace['title']]);

        $this->assertEquals($taskReplace['title'], $testTask->getTitle());
    }
    public function testTaskDelete()
    {
        $task = $this->createTask();
        $client = $this->createLoginForTest();

        $user = $this->createUser();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $userTest = $userRepository->findBy(["email" => $user['email']]);

        $client->followRedirects();
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneBy([
            "User" => $userTest[0]->getId(),
        ]);
        $crawler = $client->request('GET', '/task/' . $testTask->getId());

        $form = $crawler->selectButton('Delete')->form();
        $client->submit($form);

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneBy([
            "User" => $task['user_id'],
            "title" => $task['title']
        ]);
        $this->assertNull($testTask);
    }
    private function createUserWithRoleUser()
    {
        return [
            "email" => "antoinegibon@gmail.com"
        ];
    }
    public function testShowTaskNotLogin()
    {
        $client = $this->createClient();

        $user = $this->createUserWithRoleUser();
        $userRepository =  $this->getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail($user['email']);
        $client->loginUser($testUser);
        $client->request('GET', '/task');
        $crawler = $client->followRedirect();

        $taskRepository =  $this->getContainer()->get(TaskRepository::class);
        $testTask = $taskRepository->findOneBy(["User" => $testUser]);
        $this->assertSelectorTextContains('table', $testTask->getTitle());
        $this->assertResponseIsSuccessful('200');
    }
    public function testIndexNotLogin()
    {
        $client = $this->createClient();
        $client->followRedirects();
        $client->request('GET', '/task');

        // dd($crawler->getUri());
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('form', "Email");
    }
}
