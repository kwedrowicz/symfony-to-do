<?php

namespace AppBundle\Service;

use Lakion\ApiTestCase\JsonApiTestCase;

class AuthorizedJsonApiTestCase extends JsonApiTestCase
{
    protected $headers;

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
}
