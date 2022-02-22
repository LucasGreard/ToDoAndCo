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
            "pseudo" => "Anna"
        ];
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

        $client->submit($form);

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail($user["email"]);
        $this->assertEquals('anaelleoury40@gmail.com', $testUser->getEmail());
        $this->assertResponseIsSuccessful('201');
    }
    // public function testPasswordHash()
    // {
    //     $client = $this->createClient();
    //     $client->followRedirects();
    //     $crawler = $client->request('GET', '/register');
    //     $form = $crawler->selectButton('Register')->form();
    //     $user = $this->createUser();
    //     $form['registration_form[email]']->setValue($user["email"]);
    //     $form['registration_form[plainPassword]']->setValue($user['plainPassword']);
    //     $form['registration_form[pseudo]']->setValue($user['pseudo']);

    //     $client->submit($form);
    //     $userRepository = static::getContainer()->get(UserRepository::class);
    //     //Est-il possible d'implémenter une interface pour réutiliser la même fonction de hash que en prod ? (ici : UserPasswordHasherInterface $userPasswordHasher)
    //     $passwordHash = password_hash($user['plainPassword'], PASSWORD_BCRYPT);
    //     $testUser = $userRepository->findOneByEmail($user["email"]);
    //     $this->assertEquals($passwordHash, $testUser->getPassword());
    // }
    public function testRoleUser()
    {
        $client = $this->createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register')->form();
        $user = $this->createUser();
        $form['registration_form[email]']->setValue($user["email"]);
        $form['registration_form[plainPassword]']->setValue($user['plainPassword']);
        $form['registration_form[pseudo]']->setValue($user['pseudo']);

        $client->submit($form);
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail($user["email"]);
        $this->assertEquals(["ROLE_ADMIN"], $testUser->getRoles());
    }
}
