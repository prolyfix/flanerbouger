<?php

namespace App\Controller\Frontend;

use App\Entity\NewsletterRegistration;
use App\Message\SendEmailMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class NewsletterRegistrationController extends AbstractController
{
    #[Route('/newsletter/registration', name: 'app_frontend_newsletter_registration', methods:['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, MessageBusInterface $bus): Response
    {
        $email = $request->request->get('email');

        if (!$email) {
            return new JsonResponse(['status' => 'error', 'message' => 'Email is required'], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['status' => 'error', 'message' => 'Invalid email format'], 400);
        }

        $alreadyRegistered = $entityManager->getRepository(NewsletterRegistration::class)->findOneBy(['email' => $email]);

        if ($alreadyRegistered) {
            return new JsonResponse(['status' => 'error', 'message' => 'Email already registered'], 400);
        } else {
            // Handle new registration
            $registration = new NewsletterRegistration();
            $registration->setEmail($email);
            $entityManager->persist($registration);
            $entityManager->flush();
            $message = new SendEmailMessage(
                templatePath: 'emails/newsletter_registration.html.twig',
                context: ['email' => $email, 'uniqueId' => $registration->getUniqIdentification()],
                to: $email,
                subject: 'Flaner Bouger: Confirmez votre inscription à notre newsletter'
            );
            $bus->dispatch($message);
            return new JsonResponse(['status' => 'success', 'message' => 'Registration successful'], 201);
        }
    }

    #[Route('/newsletter/validation/{uniqueId}', name: 'app_frontend_newsletter_registration_get', methods:['GET'])]
    public function validate(string $uniqueId, EntityManagerInterface $entityManager): Response
    {
        $registration = $entityManager->getRepository(NewsletterRegistration::class)->findOneBy(['uniqIdentification' => $uniqueId]);

        if (!$registration) {
            return new JsonResponse(['status' => 'error', 'message' => 'Invalid registration'], 404);
        }
        $registration->setOptinValidationDate(new \DateTime());
        $entityManager->flush();
        return new JsonResponse(['status' => 'success', 'message' => 'Registration valid'], 200);
    
    }
}