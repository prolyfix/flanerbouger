<?php

namespace App\Controller\Frontend;

use App\Entity\Category;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class FrontendController extends AbstractController
{
    #[Route('/', name: 'app_frontend_homepage', methods:['GET'])]
    public function homepage(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('frontend/homepage.html.twig');
    }

    #[Route('/{categorySlug}', name: 'app_frontend_category', methods:['GET'])]
    public function category(Request $request, EntityManagerInterface $entityManager, string $categorySlug, EntityManagerInterface $em): Response
    {
        $category = $entityManager->getRepository(Category::class)->findOneBy(['slug' => $categorySlug]);
        $countEvents = $em->getRepository(Event::class)->getCountFutureByCategory($category);
        $mpp = $request->get('mpp', 30);
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $mpp;
        $events = $em->getRepository(Event::class)->getFutureByCategory($category, $mpp, $offset);

        return $this->render('frontend/category.html.twig', [
            'count' => $countEvents,
            'category' => $category,    
            'events' => $events,
            'mpp' => $mpp,
            'page' => $page,
        ]);
    }

    #[Route('/{categorySlug}/{eventSlug}', name: 'app_frontend_event', methods:['GET'] )]
    public function event(Request $request, EntityManagerInterface $entityManager, string $categorySlug, string $eventSlug, int $id): Response
    {
        $event = $entityManager->getRepository(Event::class)->find($id);

        if (!$event) {
            throw $this->createNotFoundException('The event does not exist');
        }

        return $this->render('frontend/event.html.twig', [
            'event' => $event,
        ]);
    }
}
