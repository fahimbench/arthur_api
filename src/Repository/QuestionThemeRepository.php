<?php

namespace App\Repository;

use App\Entity\QuestionTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionTheme[]    findAll()
 * @method QuestionTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionThemeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionTheme::class);
    }

    // /**
    //  * @return QuestionTheme[] Returns an array of QuestionTheme objects
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
    public function findOneBySomeField($value): ?QuestionTheme
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
