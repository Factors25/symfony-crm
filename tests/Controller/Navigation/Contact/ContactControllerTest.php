<?php

namespace App\Tests\Controller\Navigation\Contact;

use App\Repository\ContactRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testIndexPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/contacts/tous');
        self::assertResponseIsSuccessful();
    }

    /**
     * @throws Exception
     */
    public function testShowPage(): void
    {
        $client = static::createClient();

        $container = static::getContainer();

        $contact = $container->get(ContactRepository::class)->findOneBy([], ['id' => 'DESC']);

        $client->request('GET', '/contacts/' . $contact->getId() .'/details');
        self::assertResponseIsSuccessful();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}