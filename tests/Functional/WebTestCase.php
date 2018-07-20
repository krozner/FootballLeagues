<?php

declare(strict_types=1);

namespace Tests\Functional;

use Liip\FunctionalTestBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

abstract class WebTestCase extends BaseWebTestCase
{
    private $client = null;
    private $token  = null;

    abstract protected function provideFixtures(): array;

    public function setUp()
    {
        self::runCommand('doctrine:schema:drop --full-database');
        self::runCommand('doctrine:schema:update --force');
        self::runCommand('fos:user:create test test@test.com test');

        $this->loadFixtures($this->provideFixtures());

        $this->client = static::createClient();
        $this->token  = $this->getToken();
    }

    protected function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param $method
     * @param $uri
     * @param $data
     *
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    protected function apiRequest($method, $uri, $data = [])
    {
        $headers = [
            'content_type'  => 'application/json',
            'authorization' => "Bearer {$this->token}",
        ];

        $this->getClient()
            ->request(
                $method,
                $uri,
                [],
                [],
                $headers,
                json_encode($data)
            );

        return $this->getClient()->getResponse();
    }

    protected function getToken()
    {
        $credentials = json_encode([
            'username' => 'test',
            'password' => 'test',
        ]);

        $this->getClient()
            ->request(
                'POST',
                '/api/login_check',
                [],
                [],
                ['content_type' => 'application/json'],
                $credentials
            );

        $response = $this->getClient()->getResponse();
        $this->assertJsonResponse($response, 200, false);

        $data = json_decode($response->getContent(), true);
        $this->assertTrue(isset($data['token']), 'No JWT token returned');

        return $data['token'];
    }

    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode,
            $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }
}
