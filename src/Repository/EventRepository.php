<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getCountFutureByCategory($category): int
    {
        $qb = $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.category = :category')
            ->andWhere('e.startDate >= :now')
            ->setParameter('category', $category)
            ->setParameter('now', new \DateTime());

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
    public function getFutureByCategory($category, $limit, $offset): array
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.category = :category')
            ->andWhere('e.startDate >= :now')
            ->setParameter('category', $category)
            ->setParameter('now', new \DateTime())
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('e.startDate', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
