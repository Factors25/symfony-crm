<?php

namespace App\Service\Contact;

use App\Entity\Contact;

class LogicContactService
{
    /**
     * @param Contact $contact
     * @return string
     */
    public function displayName(Contact $contact): string
    {
        return ucfirst($contact->getFirstname()) . ' ' . mb_strtoupper($contact->getLastname());
    }
}
