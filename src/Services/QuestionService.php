<?php

namespace App\Services;

use App\Entity\QuestionLadder;
use Doctrine\ORM\EntityManagerInterface;

class QuestionService
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getLadders(){
       return $this->em->getRepository(QuestionLadder::class)->findAllAndGroupBy();
    }
}