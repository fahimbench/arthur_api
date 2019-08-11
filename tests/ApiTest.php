<?php

namespace App\Tests;

use App\Entity\QuestionTheme;
use App\Tests\ApiDataFixtureTestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\Exception as Ex;
use Symfony\Component\HttpClient\HttpClient;

class ApiTest extends ApiDataFixtureTestCase {

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Connecte un user
     */
    public function connexionUserTest(): void
    {
        $data = [
            "username" => "arthur",
            "password" => "b8kyh"
        ];
        $response = self::$httpClient->request('POST', '/login_check',[
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);

        $this->assertArrayHasKey('token', json_decode($response->getContent(), true));
        self::$token_user = json_decode($response->getContent())->token;
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Connecte un admin
     */
    public function connexionAdminTest(): void
    {
        $data = [
            "username" => "admin",
            "password" => "ded4ew"
        ];
        $response = self::$httpClient->request('POST', '/login_check',[
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);

        $this->assertArrayHasKey('token', json_decode($response->getContent(), true));
        self::$token_admin = json_decode($response->getContent())->token;
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Connecte un super admin
     */
    public function connexionSuperAdminTest(): void
    {
        $data = [
            "username" => "superadmin",
            "password" => "Ded4ewb8kyh@"
        ];
        $response = self::$httpClient->request('POST', '/login_check',[
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);

        $this->assertArrayHasKey('token', json_decode($response->getContent(), true));
        self::$token_superadmin = json_decode($response->getContent())->token;
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Tente de connecter un user non enregistrer
     */
    public function connexionWrongTest(): void
    {
        $this->expectException(ClientException::class);

        $data = [
            "username" => "admin",
            "password" => "wrongpass"
        ];
        $response = self::$httpClient->request('POST', '/login_check',[
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals('401', $response->getStatusCode());
        $this->assertEquals('Bad credentials.', json_decode($response->getContent())->message);
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Enregistre un nouvel utilisateur avec le token du superadmin
     */
    public function registerUserWithSuperAdminTest()
    {
        $data = [
            "_username" => "usertest",
            "_password" => "passwordtest"
        ];
        $response = self::$httpClient->request('POST', '/register',[
            'auth_bearer' => self::$token_superadmin,
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded',
            ],
            'body' => http_build_query($data)
        ]);

        $this->assertEquals('200', $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Enregistre un nouvel utilisateur avec le token de l'admin
     */
    public function registerUserWithoutSuperAdminTest()
    {
        $data = [
            "_username" => "usertest",
            "_password" => "passwordtest"
        ];
        $response = self::$httpClient->request('POST', '/register',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded',
            ],
            'body' => http_build_query($data)
        ]);

        $this->assertEquals('403', $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Récupere la liste des themes de question
     */
    public function getAllQuestionTheme()
    {
        $response = self::$httpClient->request('GET', '/api/question_themes',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('hydra:totalItems', json_decode($response->getContent(), true));
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Ajoute un Theme pour les questions
     */
    public function addQuestionTheme()
    {
        $data = [
            'name' => 'TestTheme'
        ];
        $response = self::$httpClient->request('POST', '/api/question_themes',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        self::$last_element = (json_decode($response->getContent()))->id;
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Récupère le précédent thème ajouté
     */
    public function getOneQuestionTheme()
    {
        $response = self::$httpClient->request('GET', '/api/question_themes/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Met à jour le précédent thème ajouté
     */
    public function updateOneQuestionTheme()
    {
        $data = [
          'name' => 'TestUpdatedTheme'
        ];
        $response = self::$httpClient->request('PUT', '/api/question_themes/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Supprime le thème précédemment ajouté
     */
    public function deleteOneQuestionTheme()
    {
        $response = self::$httpClient->request('DELETE', '/api/question_themes/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Récupere la liste de data des questions
     */
    public function getAllQuestionData()
    {
        $response = self::$httpClient->request('GET', '/api/question_datas',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('hydra:totalItems', json_decode($response->getContent(), true));
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Ajoute une question
     */
    public function addQuestionData()
    {
        $data = [
            'question' => 'Qui est le fondateur de microsoft ?',
            'answers' => '{"Bill Gates":1, "Benjamin Gates":0, "Nicolas Cage":0, "Steve Jobs": 0}',
            'resultText' => 'C\'est Bill Gates.',
            'questionTheme' => '/api/question_themes/2'
        ];
        $response = self::$httpClient->request('POST', '/api/question_datas',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        self::$last_element = (json_decode($response->getContent()))->id;
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Récupère la question précédemment crée
     */
    public function getOneQuestionData()
    {
        $response = self::$httpClient->request('GET', '/api/question_datas/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Met à jour la question précédemment crée
     */
    public function updateOneQuestionData()
    {
        $data = [
            'question' => 'Qui est le fondateur d\'Apple ?',
            'answers' => '{"Bill Gates":0, "Benjamin Gates":0, "Nicolas Cage":0, "Steve Jobs": 1}',
            'resultText' => 'C\'est Steve Jobs.',
        ];
        $response = self::$httpClient->request('PUT', '/api/question_datas/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Supprime la question précédemment crée
     */
    public function deleteOneQuestionData()
    {
        $response = self::$httpClient->request('DELETE', '/api/question_datas/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Récupere la liste du classement des questions
     */
    public function getAllQuestionLadder()
    {
        $response = self::$httpClient->request('GET', '/api/question_ladders',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('hydra:totalItems', json_decode($response->getContent(), true));
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Ajoute une personne au classement
     */
    public function addQuestionLadder()
    {
        $data = [
            'user' => 'ABC123',
            'score' => 42
        ];
        $response = self::$httpClient->request('POST', '/api/question_ladders',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        self::$last_element = (json_decode($response->getContent()))->id;
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Récupère la personne précédemment ajouté au classement
     */
    public function getOneQuestionLadder()
    {
        $response = self::$httpClient->request('GET', '/api/question_ladders/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Met à jour la personne précédemment ajouté au classement
     */
    public function updateOneQuestionLadder()
    {
        $data = [
            'score' => 69,
        ];
        $response = self::$httpClient->request('PUT', '/api/question_ladders/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Supprime la personne précédemment ajouté au classement
     */
    public function deleteOneQuestionLadder()
    {
        $response = self::$httpClient->request('DELETE', '/api/question_ladders/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Récupere la liste des groups du nikoniko
     */
    public function getAllNikoNikoGroups()
    {
        $response = self::$httpClient->request('GET', '/api/niko_niko_groups',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('hydra:totalItems', json_decode($response->getContent(), true));
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Ajoute un groupe pour planification
     */
    public function addNikoNikoGroups()
    {
        $data = [
            "name" => "2020 Dev. Python",
            "users" => ["USLACKBOT","UB7S4S8UW","UBT8HLYGN","UBTHBKUTZ","UDH83RKNG","UEK5Q3AMT","UELF9R11P","UEUJPF3LM","UGNHXFP0D","UGQR5V2A2","UHADP7EFQ"],
            "dateStart" => "2020-01-01",
            "dateEnd" => "2020-06-15",
            "dateIgnore" => [["dateStart" => "2019-09-26","dateEnd"=>"2019-10-11"]]
        ];
        $response = self::$httpClient->request('POST', '/api/niko_niko_groups',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        self::$last_element = (json_decode($response->getContent()))->id;
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Récupère le groupe crée précédemment
     */
    public function getOneNikoNikoGroups()
    {
        $response = self::$httpClient->request('GET', '/api/niko_niko_groups/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Met à jour le dernier groupe crée
     */
    public function updateOneNikoNikoGroups()
    {
        $data = [
            'name' => '2020 Dev. Symfony'
        ];
        $response = self::$httpClient->request('PUT', '/api/niko_niko_groups/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Supprime le groupe précédemment crée
     */
    public function deleteOneNikoNikoGroups()
    {
        $response = self::$httpClient->request('DELETE', '/api/niko_niko_groups/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Récupere la liste des résultats des nikoniko
     */
    public function getAllNikoNikoData()
    {
        $response = self::$httpClient->request('GET', '/api/niko_niko_datas',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('hydra:totalItems', json_decode($response->getContent(), true));
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     * Ajoute les données d'un groupe
     */
    public function addNikoNikoData()
    {
        $data = [
            'nikonikogroups' => '/api/niko_niko_groups/1',
            'dateSend' => '2019-08-11T18:17:53+00:00',
            'result' => [[
                            "userId" => "USLACKBOT",
                            "answer" => 2
                        ],
                        [
                            "userId" => "UB7S4S8UW",
                            "answer" => 4
                        ]]
        ];
        $response = self::$httpClient->request('POST', '/api/niko_niko_datas',[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        self::$last_element = (json_decode($response->getContent()))->id;
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Récupère les données du groupe précédemment crée
     */
    public function getOneNikoNikoData()
    {
        $response = self::$httpClient->request('GET', '/api/niko_niko_datas/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Met à jour les données du groupe précédemment crée
     */
    public function updateOneNikoNikoData()
    {
        $data = [
                'result' => [[
                    "userId" => "USLACKBOT",
                    "answer" => 2
                ],
                [
                    "userId" => "UB7S4S8UW",
                    "answer" => 4
                ],
                [
                    "userId" => "ABC1234",
                    "answer" => 5
                ]]
        ];
        $response = self::$httpClient->request('PUT', '/api/niko_niko_datas/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @throws Ex\TransportExceptionInterface
     * Supprime les résultats du nikoniko précédemment crée
     */
    public function deleteOneNikoNikoData()
    {
        $response = self::$httpClient->request('DELETE', '/api/niko_niko_datas/'.self::$last_element,[
            'auth_bearer' => self::$token_admin,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
        $this->assertEquals(204, $response->getStatusCode());
    }

}