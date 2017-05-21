<?php

namespace tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiDocTest extends WebTestCase
{
    public function testApiDocRequest()
    {
        $client = static::createClient();
        $client->request('GET', '/api/doc');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
