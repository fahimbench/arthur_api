<?php
// api/tests/ApiDataFixtureTestFixtureTest.php

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use \Exception;
use Symfony\Component\HttpClient\HttpClient;


class ApiDataFixtureTestCase extends WebTestCase
{

    /** @var HttpClient $httpClient */
    protected static $httpClient;

    /** @var  Application $application */
    protected static $application;

    /** @var EntityManager */
    protected static $em;

    protected static $token_user;
    protected static $token_admin;
    protected static $token_superadmin;
    protected static $last_element;

    /**
     * ApiDataFixtureTestCase constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     * @throws Exception
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        self::runCommand('doctrine:database:drop --force');
        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:create');
        self::runCommand('doctrine:schema:update');
        self::runCommand('doctrine:fixtures:load --append --no-interaction');
        self::$httpClient = HttpClient::create(['base_uri' => $_SERVER['BASE_URI']]);
        self::$em = (self::bootKernel())->getContainer()->get('doctrine')->getManager();

        parent::__construct($name, $data, $dataName);

    }

    public function setUp()
    {
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