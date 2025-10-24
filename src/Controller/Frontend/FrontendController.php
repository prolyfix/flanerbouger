<?php

namespace App\Controller\Frontend;

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
}
