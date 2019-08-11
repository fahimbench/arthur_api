<?php

namespace App\DataFixtures;

use App\Entity\NikoNikoData;
use App\Entity\NikoNikoGroups;
use Faker\Factory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;




class PlannerFixtures extends Fixture
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
//        $connection = $em->getConnection();
//        $platform = $connection->getDatabasePlatform();
//        $list = ["niko_niko_groups","niko_niko_data"];
//        $connection->query('SET FOREIGN_KEY_CHECKS=0');
//        foreach($list as $value){
//            $connection->executeUpdate($platform->getTruncateTableSQL($value, false));
//        }
//        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function load(ObjectManager $manager)
    {
        $users_id = ["USLACKBOT", "UB7S4S8UW","UBT8HLYGN","UBTHBKUTZ","UDH83RKNG","UEK5Q3AMT","UELF9R11P","UEUJPF3LM","UGNHXFP0D","UGQR5V2A2","UHADP7EFQ"];
        $promos = ["2018-2019 dev. web iot-valley", "2019 concepteur java moissac"];
        foreach($promos as $promo){
            $group = new NikoNikoGroups();
            $group->setName($promo)
                ->setUsers(json_encode($users_id))
                ->setDateStart(new \DateTime())
                ->setDateEnd((new \DateTime())->modify('+6 months'));
                $date_ignore = [
                  [
                      'dateStart' => (new \DateTime())->modify('+1 months +15 days')->format('Y-m-d'),
                      'dateEnd' => (new \DateTime())->modify('+2 months')->format('Y-m-d')
                  ]
                ];
                $group->setDateIgnore(json_encode($date_ignore));
            $manager->persist($group);
        }
        $manager->flush();
        $all2ngroups = $this->em->getRepository(NikoNikoGroups::class)->findAll();

        foreach ($all2ngroups as $group){
            $data = new NikoNikoData();
            $data->setNikonikogroups($group)
                ->setDateSend(\DateTime::createFromFormat('Y-m-d H:i:s', (new \DateTime())->format('Y-m-d H:i:s')));
            $results = [];
                foreach($users_id as $user){
                    $results[] = ['userId'=> $user, 'answer'=> rand(0,5)];
                }
                $data->setResult(json_encode($results));
            $manager->persist($data);
        }
        $manager->flush();


    }
}