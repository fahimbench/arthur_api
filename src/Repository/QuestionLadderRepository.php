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

    public function findAllAndGroupBy(){
        return $this->createQueryBuilder('l')
                ->select('count(l) as score, l.user as user, max(l.dateSend) as dateSend')
                ->groupBy('l.user')
                ->orderBy('score', 'DESC')
//              ->setMaxResults(10)
                ->getQuery()
                ->getResult();
    }
}
