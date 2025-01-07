<?php

namespace App\Repository;

use App\Entity\Candidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidature>
 */
class CandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidature::class);
    }

    /**
     * @return Candidature[] Returns an array of Candidature objects
     */
    public function findByStatus($status)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.status = :status')
            ->setParameter('status', $status)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneByBenevoleAndOffre($benevoleId, $offreId): ?Candidature
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.benevole = :benevoleId')
            ->andWhere('c.offre = :offreId')
            ->setParameter('benevoleId', $benevoleId)
            ->setParameter('offreId', $offreId)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
}
