<?php

namespace App\Tests\DataFixtures;

use App\DataFixtures\ContactFixtures;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactFixturesTest extends KernelTestCase
{
    private ContactFixtures $contactService;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $container = static::getContainer();

        $this->contactService = $container->get(ContactFixtures::class);
    }

    /**
     * @throws Exception
     */
    public function testContactFixturesCreate(): void
    {
        $manager = $this->createMock(EntityManager::class);

        $this->contactService->load($manager);

        $this->assertFalse($this->doesNotPerformAssertions());
    }

    /**
     * @throws Exception
     */
    public function testContactFixturesGroups(): void
    {
        $result = $this->contactService->getGroups();

        $this->assertEquals(['contact'], $result);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}
