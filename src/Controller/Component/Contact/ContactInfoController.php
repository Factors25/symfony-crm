<?php

namespace App\Controller\Component\Contact;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/component/contact/{contact}/info', name: 'component_contact_info')]
class ContactInfoController extends AbstractController
{
    #[Route('/get', name: '_get', methods: ['GET'])]
    public function getContactInfo(Contact $contact): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => true,
                'htmlFragment' => $this->renderView(
                    'component/contact/info/data_component.html.twig', [
                        'contact' => $contact
                    ]
                )
            ]
        );
    }
}