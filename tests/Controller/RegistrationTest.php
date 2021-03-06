<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Csrf\CsrfToken;

class RegistrationTest extends WebTestCase
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
    public function testRegistrationPageIsUp()
    {
        $client = $this->createClient();
        $client->request('GET', '/register');
        $this->assertResponseIsSuccessful();
    }
    public function testRegisterUser()
    {
        $client = $this->createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register')->form();
        $user = $this->createUser();
        $form['registration_form[email]']->setValue($user["email"]);
        $form['registration_form[plainPassword]']->setValue($user['plainPassword']);
        $form['registration_form[pseudo]']->setValue($user['pseudo']);

        $crawler = $client->submit($form);

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail($user["email"]);
        $this->assertEquals($user["email"], $testUser->getEmail());
        $this->assertResponseIsSuccessful('200');
    }
    public function testDeleteUserRegister()
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
