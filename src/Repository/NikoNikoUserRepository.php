<?php

namespace App\Repository;

use App\Entity\NikoNikoUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NikoNikoUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method NikoNikoUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method NikoNikoUser[]    findAll()
 * @method NikoNikoUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NikoNikoUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NikoNikoUser::class);
    }

    // /**
    //  * @return NikoNikoUser[] Returns an array of NikoNikoUser objects
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
    public function findOneBySomeField($value): ?NikoNikoUser
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
