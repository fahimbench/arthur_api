<?php

namespace App\Repository;

use App\Entity\AkinatorCurrentGames;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AkinatorCurrentGames|null find($id, $lockMode = null, $lockVersion = null)
 * @method AkinatorCurrentGames|null findOneBy(array $criteria, array $orderBy = null)
 * @method AkinatorCurrentGames[]    findAll()
 * @method AkinatorCurrentGames[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AkinatorCurrentGamesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AkinatorCurrentGames::class);
    }

    // /**
    //  * @return AkinatorCurrentGames[] Returns an array of AkinatorCurrentGames objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AkinatorCurrentGames
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
