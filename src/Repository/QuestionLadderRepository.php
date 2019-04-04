<?php

namespace App\Repository;

use App\Entity\QuestionLadder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionLadder|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionLadder|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionLadder[]    findAll()
 * @method QuestionLadder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionLadderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionLadder::class);
    }

    // /**
    //  * @return QuestionLadder[] Returns an array of QuestionLadder objects
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
    public function findOneBySomeField($value): ?QuestionLadder
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
