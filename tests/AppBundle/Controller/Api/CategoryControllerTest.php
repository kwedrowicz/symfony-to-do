<?php

namespace tests\AppBundle\Controller\Api;

use AppBundle\Service\AuthorizedJsonApiTestCase;

class CategoryControllerTest extends AuthorizedJsonApiTestCase
{

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
