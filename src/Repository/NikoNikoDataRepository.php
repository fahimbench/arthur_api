<?php

namespace App\Repository;

use App\Entity\NikoNikoData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NikoNikoData|null find($id, $lockMode = null, $lockVersion = null)
 * @method NikoNikoData|null findOneBy(array $criteria, array $orderBy = null)
 * @method NikoNikoData[]    findAll()
 * @method NikoNikoData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NikoNikoDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NikoNikoData::class);
    }

    // /**
    //  * @return NikoNikoData[] Returns an array of NikoNikoData objects
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
    public function findOneBySomeField($value): ?NikoNikoData
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
