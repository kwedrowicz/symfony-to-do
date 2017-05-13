<?php

namespace tests\AppBundle\Controller\Api;

use Lakion\ApiTestCase\JsonApiTestCase;

class CategoryControllerTest extends JsonApiTestCase
{
    private $headers;

    /**
     * @before
     */
    public function authorize()
    {
        $this->purgeDatabase();
        $this->loadFixturesFromFile('category.yml');
        $this->loadFixturesFromFile('user.yml');
        $this->loadFixturesFromFile('task.yml');
        $this->client->request('POST',
            '/api/login_check',
            array('_username' => 'test', '_password' => 'test')
        );
        $content = $this->client->getResponse()->getContent();
        $content = json_decode($content, true);
        $this->headers = array(
            'HTTP_AUTHORIZATION' => "Bearer {$content['token']}",
            'CONTENT_TYPE' => 'application/json',
        );
    }

    public function testCgetAction()
    {
        $this->client->request('GET', '/api/categories', array(), array(), $this->headers);
        $response =  $this->client->getResponse();
        $this->assertResponse($response, 'categories');
    }

    public function testgetAction()
    {
        $this->client->request('GET', '/api/categories', array(), array(), $this->headers);
        $categories = json_decode($this->client->getResponse()->getContent(), true);
        $id = $categories[0]['id'];
        $this->client->request('GET', "/api/categories/$id", array(), array(), $this->headers);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}
