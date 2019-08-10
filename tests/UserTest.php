<?php

use App\Tests\ApiDataFixtureTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends ApiDataFixtureTestCase {

    private $token;

    public function setUp()
    {
        parent::setUp();

    }


    /** @test
     * Test si on obtient le token et le sauvegarde pour les prochains test
     */
    public function connexionTest(): void
    {
        $response = $this->request('POST', '/login_check');
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
    }
}