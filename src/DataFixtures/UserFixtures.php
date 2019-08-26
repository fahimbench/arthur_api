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
        $list = ["user"];
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
            ["admin", "ded4ew", "ROLE_ADMIN"]
        ];

        foreach($users as $user){
            $userf = new User();
            $encoded = $this->_encoder->encodePassword($userf, $user[1]);
            $userf->setUsername($user[0])
                  ->setPassword($encoded);
            if(!empty($user[2])){
                $userf->setRoles([$user[2]]);
            }
            $manager->persist($userf);
        }
        
        $manager->flush();
    }
}