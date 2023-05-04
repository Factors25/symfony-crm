<?php

namespace App\Tests\Controller\Component\Contact;

use App\Entity\Contact;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernelBrowser;

class ContactInfoControllerTest extends WebTestCase
{
    private ObjectManager|EntityManager|null $manager;
    private HttpKernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();

        $this->manager = $this->client->getKernel()->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @throws JsonException
     */
    public function testContactGetTemplate(): void
    {
        $contact = $this->manager->getRepository(Contact::class)->findOneBy([],['id' => 'DESC']);

        $this->client->request('GET', '/component/contact/' . $contact->getId() .'/info/get');
        $response = $this->client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertJson($response->getContent());
        $success = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertTrue($success['success']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->manager->close();
        $this->manager = null;
    }
}