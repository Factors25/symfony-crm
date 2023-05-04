<?php

namespace App\Controller\Component\Contact;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Service\Contact\ApiContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/component/contact/list', name: 'component_contact_list')]
class ContactListController extends AbstractController
{
    public function __construct(
        private RouterInterface $router,
        private ApiContactService $apiContactService,
        private ContactRepository $contactRepository
    ) {}

    #[Route('/get', name: '_get', methods: ['GET'])]
    public function getContactList(): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => true,
                'htmlFragment' => $this->renderView(
                    'component/contact/list/data_component.html.twig', [
                        'contacts' => $this->contactRepository->findAll()
                    ]
                )
            ]
        );
    }

    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function createContact(Request $request): JsonResponse
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() === true) {
            if ($form->isValid() === true) {

                $success = $this->apiContactService->create($contact);

                if ($success['success'] === true) {
                    $redirectUrl = $this->router->generate('contact_show', ['contact' => $contact->getId()]);
                    return new JsonResponse(['success' => true, 'redirectUrl' => $redirectUrl]);
                }
            }

            $htmlFragment = $this->renderView('component/contact/list/form_component.html.twig', ['form' => $form->createView()]);

            return new JsonResponse(['success' => false, 'htmlFragment' => $htmlFragment]);
        }

        $htmlFragment = $this->renderView('component/contact/list/form_component.html.twig', ['form' => $form->createView()]);

        return new JsonResponse(['htmlFragment' => $htmlFragment]);
    }

    #[Route('/{contact}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function editContact(Contact $contact, Request $request): JsonResponse
    {
        $form = $this->createForm(ContactType::class, $contact, [
            'edit' => true
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() === true) {
            if ($form->isValid() === true) {

                $success = $this->apiContactService->update($contact);

                if ($success['success'] === true) {
                    return new JsonResponse(['success' => true]);
                }
            }

            $htmlFragment = $this->renderView('component/contact/list/form_component.html.twig', ['form' => $form->createView()]);

            return new JsonResponse(['success' => false, 'htmlFragment' => $htmlFragment]);
        }

        $htmlFragment = $this->renderView('component/contact/list/form_component.html.twig', ['form' => $form->createView()]);

        return new JsonResponse(['htmlFragment' => $htmlFragment]);
    }

    #[Route('/{contact}/delete', name: '_delete', methods: ['GET', 'DELETE'])]
    public function deleteContact(Contact $contact, Request $request): JsonResponse
    {
        $htmlFragment = $this->renderView('component/contact/list/delete_component.html.twig');

        if ($request->getMethod() === Request::METHOD_GET) {
            return new JsonResponse(['htmlFragment' => $htmlFragment]);
        }

        $csrf = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-resource', $csrf)) {

            $deletion = $this->apiContactService->delete($contact);

            if ($deletion['success'] === false) {
                $htmlFragment = $this->renderView('component/contact/list/delete_component.html.twig', [
                    'errors' => $deletion['errors']
                ]);

                return new JsonResponse(['success' => false, 'htmlFragment' => $htmlFragment]);
            }

            if((int)$request->get('redirect') === 1) {
                $redirectUrl = $this->router->generate('contact_index');
                return new JsonResponse(['success' => true, 'redirectUrl' => $redirectUrl]);
            }

            return new JsonResponse(['success' => true]);
        }

        return new JsonResponse(['htmlFragment' => $htmlFragment]);
    }
}