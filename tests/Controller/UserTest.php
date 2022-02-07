<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
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
    public function testUserPageIsUp()
    {
        $client = $this->createLoginForTest();

        $client->request('GET', '/user');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('td', 'lucas.greard07@gmail.com');
    }
    public function testUserNew()
    {
        $client = $this->createLoginForTest();
    }
    public function testUserShow()
    {
        $client = $this->createLoginForTest();
        $client->request('GET', '/user/2');
        $this->assertResponseIsSuccessful();
    }
    public function testUserEdit()
    {
    }
    public function testUserDelete()
    {
    }
}
