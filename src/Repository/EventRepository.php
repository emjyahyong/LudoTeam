<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Recherche des événements par critères (nom, date, participants)
     *
     * @param string|null $name
     * @param \DateTime|null $date
     * @param int|null $participants
     * @return Event[]
     */
    public function findByCriteria(?string $name, ?\DateTime $date, ?int $participants): array
{
    $qb = $this->createQueryBuilder('e');

    if ($name) {
        $qb->andWhere('e.name LIKE :name')
           ->setParameter('name', '%' . $name . '%');
    }

    if ($date) {
        $qb->andWhere('e.date = :date')
           ->setParameter('date', $date);
    }

    if ($participants !== null) {
        $qb->andWhere('e.participants >= :participants')
           ->setParameter('participants', $participants);
    }

    return $qb->getQuery()->getResult();
}

}