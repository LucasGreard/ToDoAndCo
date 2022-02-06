<?php

namespace App\Tests\Controller;

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
        $form['registration_form[email]']->setValue('anaelleoury@gmail.com');
        $form['registration_form[plainPassword]']->setValue('prout50');
        $client->submit($form);
        dd($client->getResponse()->getContent());
    }
}
