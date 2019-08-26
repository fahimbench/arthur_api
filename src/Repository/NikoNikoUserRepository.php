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

    /**
     * @param $group
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAndCountUserInGroup($group){
        return $this->createQueryBuilder('u')
                    ->select('count(u.nikoNikoGroups) as count')
                    ->where('u.nikoNikoGroups = :group')
                    ->setParameter('group', $group)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}
