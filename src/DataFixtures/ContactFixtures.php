<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createContact($manager);
    }

    public function createContact(ObjectManager $manager): void
    {
        $contact = new Contact();
        $contact
            ->setFirstname('Alexis')
            ->setLastname('PY')
            ->setPhoneNumber('0778556587')
            ->setEmail('alexis25.py@gmail.com')
        ;

        $manager->persist($contact);
        $manager->flush();
    }

    public function getGroups(): array
    {
        return ['contact'];
    }
}
