<?php

namespace App\Controller\Navigation\Contact;

use App\Entity\Contact;
use App\Service\Contact\LogicContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contacts', name: 'contact')]
class ContactController extends AbstractController
{
    #[Route('/tous', name: '_index')]
    public function index(): Response
    {
        return $this->render('navigation/contact/index.html.twig');
    }

    #[Route('/{contact}/details', name: '_show')]
    public function show(Contact $contact, LogicContactService $logicContactService): Response
    {
        return $this->render('navigation/contact/show.html.twig', [
            'contact_id' => $contact->getId(),
            'contact_name' => $logicContactService->displayName($contact)
        ]);
    }
}
