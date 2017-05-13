<?php

namespace tests\AppBundle\Controller\Api;

use Lakion\ApiTestCase\JsonApiTestCase;

class AuthorizationTest extends JsonApiTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageNotAuthorized($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertResponse($client->getResponse(), 'token_not_found', 401);
    }

    /**
     * @dataProvider urlProvider
     */
    public function testBadCredentials($url)
    {
        $client = self::createClient();
        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer 1231231231312",
            'CONTENT_TYPE' => 'application/json',
        );
        $client->request('GET', $url, array(), array(), $headers);
        $this->assertResponse($client->getResponse(), 'invalid_token', 401);
    }

    public function testCorrectLogin()
    {
        $this->loadFixturesFromFile('user.yml');
        $this->client->request('POST',
            '/api/login_check',
            array('_username' => 'test', '_password' => 'test')
        );
        $this->assertResponse($this->client->getResponse(), 'login_success');
    }

    public function testFailedLogin()
    {
        $this->loadFixturesFromFile('user.yml');
        $this->client->request('POST',
            '/api/login_check',
            array('_username' => 'test', '_password' => 'test123')
        );
        $this->assertResponse($this->client->getResponse(), 'login_failed', 401);
    }

    public function urlProvider()
    {
        return array(
            array('/api/tasks'),
            array('/api/categories'),
            array('/api/tags')
        );
    }
}

