<?php
// api/tests/ApiDataFixtureTestFixtureTest.php

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use \Exception;


class ApiDataFixtureTestCase extends WebTestCase
{

    /** @var  Application $application */
    protected static $application;

    /** @var  EntityManager $entityManager */
    protected $entityManager;

    protected static $token;

    /**
     * @throws Exception
     */
    public function setUp()
    {
        self::runCommand('doctrine:database:drop --force');
        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:create');
        self::runCommand('doctrine:schema:update');
        self::runCommand('doctrine:fixtures:load --append --no-interaction');

        parent::setUp();
    }

    /**
     * @param $command
     * @return int
     * @throws Exception
     */
    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    /**
     * @return Application
     */
    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

//    /**
//     * @throws Exception
//     * Supprime la base de donnée à la fin des tests !
//     */
//    protected function tearDown()
//    {
//        self::runCommand('doctrine:database:drop --force');
//
//        parent::tearDown();
//
//        $this->entityManager->close();
//        $this->entityManager = null; // avoid memory leaks
//    }
}