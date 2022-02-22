<?php

namespace App\Tests\Controller;

use App\Exception\ResourceValidationException;
use App\Repository\UserRepository;
use Doctrine\Migrations\Configuration\EntityManager\ManagerRegistryEntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Csrf\CsrfToken;

class UserTest extends WebTestCase
{

    private function createUser()
    {
        return [
            "email" => "anaelleoury40@gmail.com",
            "plainPassword" => "jetest50",
            "pseudo" => "Anna",
            "role" => "ROLE_ADMIN"
        ];
    }
    private function userForLogin()
    {
        return [
            "email" => "lucas.greard07@gmail.com",

        ];
    }
    private function createLoginForTest()
    {
        $client = $this->createClient();
        $user = $this->userForLogin();
        $userRepository =  $this->getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail($user['email']);
        return $client->loginUser($testUser);
    }
    public function testUserPageIsUp()
    {
        $client = $this->createLoginForTest();

        $client->request('GET', '/user');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('footer', 'Copyright');
    }

    public function testUserNew()
    {
        $client = $this->createLoginForTest();
        $client->followRedirects();
        $crawler = $client->request('GET', '/user/new');

        $user = $this->createUser();

        $form = $crawler->selectButton('Save')->form();
        $form['user[email]']->setValue($user['email']);
        $form['user[pseudo]']->setValue($user['pseudo']);
        $form['user[plainPassword]']->setValue($user['plainPassword']);
        $form['user[roles]']->setValue($user['role']);
        $client->submit($form);

        $crawler = $client->followRedirects();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(["email" => $user['email']]);

        $user = $this->createUser();
        $this->assertEquals($user['email'], $testUser->getEmail());
    }

    public function testUserShow()
    {
        $client = $this->createLoginForTest();

        $user = $this->createUser();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(["email" => $user['email']]);

        $client->request('GET', '/user/' . $testUser->getId());
        $this->assertSelectorTextContains('table', $user['email']);
    }

    public function testUserEdit()
    {
        $client = $this->createLoginForTest();
        $client->followRedirects();

        $user = $this->createUser();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(["email" => $user['email']]);

        $client->request('GET', '/user/' . $testUser->getId() . '/edit');

        $this->assertResponseIsSuccessful();
        $this->assertInputValueSame('user_edit[email]', $user['email']);
    }
    public function testUserDelete()
    {
        $user = $this->createUser();
        $client = $this->createLoginForTest();
        $client->followRedirects();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail($user['email']);
        $crawler = $client->request('GET', '/user/' . $testUser->getId());

        $form = $crawler->selectButton('Delete')->form();
        $client->submit($form);

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail($user['email']);

        $this->assertNull($testUser);
    }
}
