<?php

namespace App\Tests\Controller\Component\Contact;

use App\Repository\ContactRepository;
use Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactListControllerTest extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public function testContactGetTemplate(): void
    {
        $client = static::createClient();
        $client->request('GET', '/component/contact/list/get');
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());
        $success = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertTrue($success['success']);
    }

    /**
     * @throws Exception
     */
    public function testContactDelete(): void
    {
        $client = static::createClient();

        $container = static::getContainer();

        $contact = $container->get(ContactRepository::class)->findOneBy([], ['id' => 'DESC']);

        $client->request('GET', '/component/contact/list/' . $contact->getId() . '/delete');
        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());

        $client->request('DELETE', '/component/contact/list/' . $contact->getId() . '/delete');
        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());
    }

    /**
     * @throws Exception
     */
    public function testContactCreate(): void
    {
        $client = static::createClient();

        $client->request('GET', '/component/contact/list/new');

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());

        $client->request('POST', '/component/contact/list/new');

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());
    }

    /**
     * @throws Exception
     */
    public function testContactEdit(): void
    {
        $client = static::createClient();

        $container = static::getContainer();

        $contact = $container->get(ContactRepository::class)->findOneBy([], ['id' => 'DESC']);

        $client->request('GET', '/component/contact/list/' . $contact->getId() . '/edit');

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());

        $client->request('POST', '/component/contact/list/' . $contact->getId() . '/edit');

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}