<?php

namespace App\Repository;

use App\Entity\NikoNikoGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NikoNikoGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method NikoNikoGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method NikoNikoGroup[]    findAll()
 * @method NikoNikoGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NikoNikoGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NikoNikoGroup::class);
    }

    // /**
    //  * @return NikoNikoGroups[] Returns an array of NikoNikoGroups objects
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
    public function findOneBySomeField($value): ?NikoNikoGroups
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
