<?php

namespace App\Repository;

use App\Entity\QuestionData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionData|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionData|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionData[]    findAll()
 * @method QuestionData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionData::class);
    }

    // /**
    //  * @return QuestionData[] Returns an array of QuestionData objects
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
    public function findOneBySomeField($value): ?QuestionData
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
