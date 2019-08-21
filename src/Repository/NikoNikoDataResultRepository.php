<?php

namespace App\Repository;

use App\Entity\NikoNikoDataResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NikoNikoDataResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method NikoNikoDataResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method NikoNikoDataResult[]    findAll()
 * @method NikoNikoDataResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NikoNikoDataResultRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NikoNikoDataResult::class);
    }

    // /**
    //  * @return NikoNikoDataResult[] Returns an array of NikoNikoDataResult objects
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
    public function findOneBySomeField($value): ?NikoNikoDataResult
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
