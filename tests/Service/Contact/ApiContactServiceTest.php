<?php

namespace App\Tests\Service\Contact;

use App\Entity\Contact;
use App\Service\Contact\ApiContactService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Repository\ContactRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiContactServiceTest extends KernelTestCase
{
    private ApiContactService $contactService;
    private ContainerInterface $container;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->container = static::getContainer();

        $this->contactService = $this->container->get(ApiContactService::class);
    }

    /**
     * @throws Exception
     */
    public function testContactCreateSuccess(): void
    {
        $contact = new Contact();

        $contact
            ->setFirstname('Alexis')
            ->setLastname('PY')
            ->setEmail('alexis25.py@gmail.com')
        ;

        $result = $this->contactService->create($contact);

        $this->assertTrue($result['success']);
    }

    /**
     * @throws Exception
     */
    public function testContactCreateFail(): void
    {
        $contact = new Contact();

        $contact
            ->setLastname('PY')
            ->setEmail('alexis25.py@gmail.com')
            ->setPhoneNumber('0778556587')
        ;

        $result = $this->contactService->create($contact);

        $this->assertFalse($result['success']);
    }

    /**
     * @throws Exception
     */
    public function testContactUpdateSuccess(): void
    {
        $contact = $this->container->get(ContactRepository::class)->findOneBy([],['id'=>'DESC']);

        $contact->setFirstname('Thomas');

        $result = $this->contactService->update($contact);

        $this->assertTrue($result['success']);
    }

    /**
     * @throws Exception
     */
    public function testContactUpdateFail(): void
    {
        $contact = $this->container->get(ContactRepository::class)->findOneBy([],['id'=>'DESC']);

        $contact->setEmail('test');

        $result = $this->contactService->update($contact);

        $this->assertFalse($result['success']);
    }

    /**
     * @throws Exception
     */
    public function testContactDeleteSuccess(): void
    {
        $contact = $this->container->get(ContactRepository::class)->findOneBy([],['id'=>'DESC']);

        $result = $this->contactService->delete($contact);

        $this->assertTrue($result['success']);
    }

    /**
     * @throws Exception
     */
    public function testContactGetId(): void
    {
        $contact = $this->container->get(ContactRepository::class)->findOneBy([],['id'=>'DESC']);

        $result = $contact->getId();

        $this->assertIsInt($result);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}
