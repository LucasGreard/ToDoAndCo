<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    public function testHomepageIsUp()
    {
        $client = $this->createClient();
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }
}
