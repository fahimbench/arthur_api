<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\QuestionTheme;
use App\Entity\QuestionData;
use App\Entity\QuestionLadder;

class QuestionFixtures extends Fixture
{


    public function __construct(EntityManagerInterface $em)
    {
        $connection = $em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $list = ["question_data","question_ladder","question_theme"];
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        foreach($list as $value){
            $connection->executeUpdate($platform->getTruncateTableSQL($value, false));
        }
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }

    public function load(ObjectManager $manager)
    {
        $users_id = ["USLACKBOT", "UB7S4S8UW","UBT8HLYGN","UBTHBKUTZ","UDH83RKNG","UEK5Q3AMT","UELF9R11P","UEUJPF3LM","UGNHXFP0D","UGQR5V2A2","UHADP7EFQ"];
        $theme_array = ["Culture G", "HTML/CSS", "JAVA", "J2E", "JS", "Algorithmie", "SQL", "PHP"];
        $response = [
            ["text" => "answer1", "bog" => true],
            ["text" => "answer2", "bog" => false],
            ["text" => "answer3", "bog" => false],
            ["text" => "answer4", "bog" => false],
        ];
        foreach ($theme_array as $theme){
            $qtheme = (new QuestionTheme())
                ->setName($theme);
            $manager->persist($qtheme);
            for($i = 1; $i <= rand(2, 10); $i++){
                $qdata = (new QuestionData())
                    ->setQuestionTheme($qtheme)
                    ->setQuestion("Question$i du thème ".$qtheme->getName())
                    ->setAnswers(json_encode($response))
                    ->setResultText("Text explicatif de la réponse ou un lien");
                $manager->persist($qdata);
            }
        }
        $manager->flush();
        $qsdata = $manager->getRepository(QuestionData::class);
        $dataCount = count($qsdata->findAll());

        foreach ($users_id as $u){
            for($i=0; $i < rand(5,100); $i++){
                $qladder = (new QuestionLadder())
                    ->setUser($u)
                    ->setQuestionData($qsdata->find(rand(1, $dataCount)));
                $manager->persist($qladder);
                }
        }

        $manager->flush();

        }
    }