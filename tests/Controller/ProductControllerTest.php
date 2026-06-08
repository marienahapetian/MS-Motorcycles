<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/shop');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Shop');
    }
}
