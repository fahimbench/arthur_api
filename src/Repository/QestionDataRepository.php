<?php

namespace App\Repository;

use App\Entity\QestionData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QestionData|null find($id, $lockMode = null, $lockVersion = null)
 * @method QestionData|null findOneBy(array $criteria, array $orderBy = null)
 * @method QestionData[]    findAll()
 * @method QestionData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QestionDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QestionData::class);
    }

    // /**
    //  * @return QestionData[] Returns an array of QestionData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QestionData
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
