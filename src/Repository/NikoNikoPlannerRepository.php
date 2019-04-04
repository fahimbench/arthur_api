<?php

namespace App\Repository;

use App\Entity\NikoNikoPlanner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NikoNikoPlanner|null find($id, $lockMode = null, $lockVersion = null)
 * @method NikoNikoPlanner|null findOneBy(array $criteria, array $orderBy = null)
 * @method NikoNikoPlanner[]    findAll()
 * @method NikoNikoPlanner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NikoNikoPlannerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NikoNikoPlanner::class);
    }

    // /**
    //  * @return NikoNikoPlanner[] Returns an array of NikoNikoPlanner objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NikoNikoPlanner
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
