<?php

namespace App\Tests\Form;

namespace App\Tests\Form;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Form\Test\TypeTestCase;

class ContactTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'firstname' => 'alexis',
            'lastname' => 'py',
            'email' => 'alexis25.py@gmail.com',
            'phoneNumber' => '0778556587'
        ];

        $model = new Contact();
        $form = $this->factory->create(ContactType::class, $model);

        $expected = new Contact();
        $expected
            ->setFirstname($formData['firstname'])
            ->setLastname($formData['lastname'])
            ->setEmail($formData['email'])
            ->setPhoneNumber($formData['phoneNumber'])
        ;

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($expected, $model);
    }

    public function testCustomFormView(): void
    {
        $formData = new Contact();
        $formData
            ->setFirstname('alexis')
            ->setLastname('py')
            ->setEmail('alexis25.py@gmail.com')
            ->setPhoneNumber('0778556587')
        ;

        $view = $this->factory->create(ContactType::class, $formData)
            ->createView();

        $this->assertArrayHasKey('name', $view->vars);
        $this->assertEquals('contact', $view->vars['name']);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}