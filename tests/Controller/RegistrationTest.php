<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationTest extends WebTestCase
{
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
        $form['registration_form[email]']->setValue('anaelleoury40@gmail.com');
        $form['registration_form[plainPassword]']->setValue('prout50');

        $client->submit($form);
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('anaelleoury40@gmail.com');

        $this->assertEquals('anaelleoury40@gmail.com', $testUser->getEmail());
        $this->assertResponseIsSuccessful('201');
    }
}
