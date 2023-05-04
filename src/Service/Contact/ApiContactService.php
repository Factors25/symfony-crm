<?php

namespace App\Service\Contact;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiContactService
{
    public function __construct(
        private EntityManagerInterface $em,
        private ValidatorInterface $validator
    ) {}

    public function create(Contact $contact): array
    {
        $errors = $this->validator->validate($contact);

        if (count($errors) > 0) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        $this->em->persist($contact);
        $this->em->flush();

        return ['success' => true];
    }

    public function update(Contact $contact): array
    {
        $errors = $this->validator->validate($contact);

        if (count($errors) > 0) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        $this->em->persist($contact);
        $this->em->flush();

        return ['success' => true];
    }

    public function delete(Contact $contact): array
    {
        $this->em->remove($contact);
        $this->em->flush();

        return ['success' => true];
    }
}
