<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;




class PlannerFixtures extends Fixture
{


    public function __construct(EntityManagerInterface $em)
    {
        $connection = $em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $list = ["niko_niko_planner","niko_niko_groups","niko_niko_data"];
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        foreach($list as $value){
            $connection->executeUpdate($platform->getTruncateTableSQL($value, false));
        }
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function load(ObjectManager $manager)
    {

    }
}