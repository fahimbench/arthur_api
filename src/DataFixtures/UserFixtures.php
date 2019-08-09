<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;




class UserFixtures extends Fixture
{
    private $_encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $connection = $em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $list = ["users"];
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        foreach($list as $value){
            $connection->executeUpdate($platform->getTruncateTableSQL($value, false));
        }
        $connection->query('SET FOREIGN_KEY_CHECKS=1');

        $this->_encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            ["arthur", "b8kyh"],
            ["admin", "ded4ew"]
        ];

        foreach($users as $user){
            $userf = new User($user[0]);
            $encoded = $this->_encoder->encodePassword($userf, $user[1]);
            $userf->setPassword($encoded);
            $manager->persist($userf);
        }
        
        $manager->flush();
    }
}