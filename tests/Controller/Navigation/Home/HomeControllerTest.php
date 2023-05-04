<?php

namespace App\Tests\Controller\Navigation\Home;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndexPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');
        self::assertResponseIsSuccessful();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}