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
        $this->assertSelectorTextContains('footer', 'Copyright');
    }

    public function testUserNew()
    {
        $client = $this->createLoginForTest();
        $client->followRedirects();
        $crawler = $client->request('GET', '/user/new');
        $form = $crawler->selectButton('Save')->form();

        $form['user[email]']->setValue('anaelleoury40@gmail.com');
        $form['user[plainPassword]']->setValue('prout50');
        $form['user[roles]']->setValue('ROLE_USER');

        $client->submit($form);
        $crawler = $client->followRedirects();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('anaelleoury40@gmail.com');

        $this->assertEquals('anaelleoury40@gmail.com', $testUser->getEmail());
        $this->assertResponseIsSuccessful();
    }

    public function testUserShow()
    {
        $client = $this->createLoginForTest();
        $client->request('GET', '/user/2');
        $this->assertResponseIsSuccessful();
    }
    public function testUserShowWithWrongId()
    {
        $client = $this->createLoginForTest();
        $client->followRedirects();
        $client->request('GET', '/user/a');
        $this->assertRouteSame('user_index');
        $this->assertResponseIsSuccessful();
    }
    public function testUserEdit()
    {
        $client = $this->createLoginForTest();
        $client->followRedirects();
        $crawler = $client->request('GET', '/user/2/edit');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Update')->form();

        $form['user_edit[email]']->setValue('lucas.greard07@gmail.com');

        $client->submit($form);
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('lucas.greard07@gmail.com');

        $this->assertEquals('lucas.greard07@gmail.com', $testUser->getEmail());
    }
    public function testUserDelete()
    {
        $client = $this->createLoginForTest();
        $client->followRedirects();
        $crawler = $client->request('GET', '/user/new');
        $form = $crawler->selectButton('Save')->form();
        $email = 'anaelleoury40@gmail.com' . rand(1, 100);
        $email = 'anaelleoury40@gmail.com20';
        $form['user[email]']->setValue($email);
        $form['user[plainPassword]']->setValue('prout50');
        $form['user[roles]']->setValue('ROLE_USER');
        $tkn = new CsrfToken("23", "delete");
        $form['user[_token]']->setValue($tkn->__toString());

        $client->submit($form);
        $crawler = $client->followRedirects();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail($email);

        $crawler = $client->request('POST', '/user/23');
        $crawler = $client->followRedirects();


        $this->assertEquals(1, 1);
    }
}
