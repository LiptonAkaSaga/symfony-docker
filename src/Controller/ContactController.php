<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactFormType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            $email = (new Email())
                ->from($contactMessage->getEmail())
                ->to('tekken127@gmail.com')
                ->subject('Nowa wiadomość kontaktowa')
                ->text('Od: ' . $contactMessage->getName() . "\n" .
                    'Email: ' . $contactMessage->getEmail() . "\n\n" .
                    $contactMessage->getMessage());

            $mailer->send($email);

            $this->addFlash('success', 'Twoja wiadomość została wysłana!');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
