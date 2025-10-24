<?php

namespace App\EventSubscriber;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{

    public function __construct(private Environment $twig, private Security $security, private EntityManagerInterface $em)
    {

    }

    public function onControllerEvent(ControllerEvent $event): void
    {
        $categories = $this->em->getRepository(Category::class)->findAll();
        $categoriesTree = [];
        foreach($categories as $category) {
            if($category->getParent() === null) {
                $categoriesTree[$category->getTitle()] = [
                    $category
                ];
            } else {
                $categoriesTree[$category->getParent()->getTitle()][] = $category;
            }
        }

        $this->twig->addGlobal('categories', $categoriesTree);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
