<?php

namespace App\Tests\Service\Contact;

use App\Entity\Contact;
use App\Service\Contact\LogicContactService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LogicContactServiceTest extends KernelTestCase
{
    private LogicContactService $contactService;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->contactService = $container->get(LogicContactService::class);
    }

    /**
     * @throws Exception
     */
    public function testContactDisplayName(): void
    {
        $contact = $this->createMock(Contact::class);
        $contact
            ->expects($this->once())
            ->method('getFirstname')
            ->willReturn('alexis');
        $contact
            ->expects($this->once())
            ->method('getLastname')
            ->willReturn('py');

        $this->assertEquals('Alexis PY', $this->contactService->displayName($contact));
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}
