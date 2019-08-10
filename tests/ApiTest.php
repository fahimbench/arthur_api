<?php

namespace App\Tests;

use App\Tests\ApiDataFixtureTestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\Exception as Ex;
use Symfony\Component\HttpClient\HttpClient;

class ApiTest extends ApiDataFixtureTestCase {

    /**
     * @before
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     */
    public function connexionTest(): void
    {
        $httpClient = HttpClient::create([
            'base_uri' => $_SERVER['BASE_URI']
        ]);
        $data = [
            "username" => "admin",
            "password" => "ded4ew"
        ];
        $response = $httpClient->request('POST', '/login_check',[
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);

        $this->assertArrayHasKey('token', json_decode($response->getContent(), true));
        self::$token = json_decode($response->getContent())->token;
    }

    /**
     * @test
     * @throws Ex\ClientExceptionInterface
     * @throws Ex\RedirectionExceptionInterface
     * @throws Ex\ServerExceptionInterface
     * @throws Ex\TransportExceptionInterface
     */
    public function connexionWrongTest(): void
    {
        $this->expectException(ClientException::class);

        $httpClient = HttpClient::create([
            'base_uri' => $_SERVER['BASE_URI'],
        ]);
        $data = [
            "username" => "admin",
            "password" => "wrongpass"
        ];
        $response = $httpClient->request('POST', '/login_check',[
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals('401', $response->getStatusCode());
        $this->assertEquals('Bad credentials.', json_decode($response->getContent())->message);
    }

}