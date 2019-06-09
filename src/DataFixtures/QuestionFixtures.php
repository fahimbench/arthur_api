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
        $theme_array = ["Culture G", "HTML/CSS", "JAVA", "J2E", "JS", "Algorithmie", "SQL", "PHP"];
        foreach($theme_array as $theme){
            $qtheme = new QuestionTheme();
            $qtheme->setName($theme);
            $manager->persist($qtheme);
            for($i = 1; $i <= rand(2, 10); $i++){
                $qdata = new QuestionData();
                $qdata  ->setQuestion("Question$i du theme ".$qtheme->getName())
                        ->setAnswers("{\"answer1\":0, \"answer2\":0, \"answer3\":1, \"answer4\":0}")
                        ->setFkIdTheme($qtheme)
                        ->setResultText("Blabla un texte explicatif de la réponse ou un lien");
                $manager->persist($qdata);
            }
        }
        for($i = 1; $i <= 25; $i++){
            $qladder = new QuestionLadder();
            $qladder->setUser(rand(100, 999)."ABC")
                    ->setScore(rand(1,30));
            $manager->persist($qladder);
        }
        $manager->flush();
    }
}