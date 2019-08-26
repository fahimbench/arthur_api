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

    /**
     * @param $group
     * @param $date
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findDataWithDate($group, $date){
        return $this->createQueryBuilder('r')
                    ->leftJoin('r.nikoNikoData', 'd')
                    ->select('sum(r.score) as score')
                    ->where('d.nikoNikoGroups = :group')
                    ->andWhere('d.dateSend LIKE :date')
                    ->andWhere('r.score >= 0')
                    ->setParameters([
                        'date' => '%'.$date.'%',
                        'group' =>  $group
                    ])
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * @param $group
     * @param $date
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findNullDataWithDate($group, $date){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.nikoNikoData', 'd')
            ->where('d.nikoNikoGroups = :group')
            ->andWhere('d.dateSend LIKE :date')
            ->andWhere("r.score is null")
            ->setParameters([
                'date' => '%'.$date.'%',
                'group' =>  $group
            ])
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $group
     * @param $date
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findMinusOneDataWithDate($group, $date){
        return $this->createQueryBuilder('r')
            ->leftJoin('r.nikoNikoData', 'd')
            ->where('d.nikoNikoGroups = :group')
            ->andWhere('d.dateSend LIKE :date')
            ->andWhere('r.score = -1')
            ->setParameters([
                'date' => '%'.$date.'%',
                'group' =>  $group
            ])
            ->getQuery()
            ->getResult();
    }
}
