<?php

namespace App\DataFixtures;

use App\Entity\NikoNikoData;
use App\Entity\NikoNikoDataResult;
use App\Entity\NikoNikoGroup;
use App\Entity\NikoNikoUser;
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
        $connection = $em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $list = ["niko_niko_group","niko_niko_data", "niko_niko_user", "niko_niko_data_result"];
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        foreach($list as $value){
            $connection->executeUpdate($platform->getTruncateTableSQL($value, false));
        }
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $nikonikogroup = $this->em->getRepository(NikoNikoGroup::class);
        $nikonikouser = $this->em->getRepository(NikoNikoUser::class);

        $users_id = ["USLACKBOT", "UB7S4S8UW","UBT8HLYGN","UBTHBKUTZ","UDH83RKNG","UEK5Q3AMT","UELF9R11P","UEUJPF3LM","UGNHXFP0D","UGQR5V2A2","UHADP7EFQ"];
        $promos = ["2018-2019 dev. web iot-valley", "2019 concepteur java moissac"];
        $lastYear = (new \DateTime())->modify('-1 year');
        $lastYearSave = $lastYear;

        foreach($promos as $promo){
            $group = new NikoNikoGroup();
            $group->setName($promo)
                ->setDateStart($lastYear)
                ->setDateEnd((new \DateTime($lastYear->format("Y-m-d")))->modify('+10 months'));
            $date_ignore = [
                [
                    'dateStart' => (new \DateTime($lastYear->format("Y-m-d")))->modify('+4 months +15 days')->format('Y-m-d'),
                    'dateEnd' => (new \DateTime($lastYear->format("Y-m-d")))->modify('+5 months')->format('Y-m-d')
                ],
                [
                    'dateStart' => (new \DateTime($lastYear->format("Y-m-d")))->modify('+7 months +15 days')->format('Y-m-d'),
                    'dateEnd' => (new \DateTime($lastYear->format("Y-m-d")))->modify('+8 months')->format('Y-m-d')
                ]
            ];
            $group->setDateIgnore($date_ignore);
            $manager->persist($group);
        }
        $manager->flush();

        for($i=0; $i < 5; $i++) {
            $user = (new NikoNikoUser())
                ->setIdSlack($users_id[$i])
                ->setNikoNikoGroups($nikonikogroup->find(1));
            $manager->persist($user);
        }

        for($i=5; $i < 11; $i++) {
            $user = (new NikoNikoUser())
                ->setIdSlack($users_id[$i])
                ->setNikoNikoGroups($nikonikogroup->find(2));
            $manager->persist($user);
        }
        if($lastYear->format('D') != 'Mon'){
            $lastYear->modify('next monday +10 hours');
        }

        foreach ($nikonikogroup->findAll() as $group){
            $lastYear = (new \DateTime())->modify('-1 year');
            $ending = (new \DateTime($lastYearSave->format("Y-m-d")))->modify('+10 months');
            do{

                $ignore = $group->getDateIgnore();

                $verify = array_filter($ignore, function($n) use ($lastYear){
                    $d1 = (new \DateTime($n['dateStart']));
                    $d2 = (new \DateTime($n['dateEnd']));

                    return ($lastYear >= $d1 && $lastYear <= $d2);
                });

                if(empty($verify)){
                    $data = (new NikoNikoData())
                        ->setNikonikogroups($group)
                        ->setDateSend((new \DateTime($lastYear->format("Y-m-d H:m:i"))));
                    $manager->persist($data);
                    $manager->flush();
                    foreach($nikonikouser->findBy(["nikoNikoGroups"=> $data->getNikonikogroups()]) as $user){
                        $resultData = (new NikoNikoDataResult())
                            ->setScore(rand(0,4))
                            ->setNikoNikoData($data)
                            ->setDateResponse((new \DateTime($lastYear->format("Y-m-d H:m:i")))->modify("+".rand(0,3)." days +".rand(1,8)." hours"));
                        $manager->persist($resultData);
                        $manager->flush();
                    }
                }
                $lastYear->modify('next monday +10 hours');
            }while($lastYear < $ending);
        }


    }
}