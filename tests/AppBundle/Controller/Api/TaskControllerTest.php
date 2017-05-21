<?php

namespace tests\AppBundle\Controller\Api;

use AppBundle\Service\AuthorizedJsonApiTestCase;

class TaskControllerTest extends AuthorizedJsonApiTestCase
{
    public function testCgetAction()
    {
        $this->client->request('GET', '/api/tasks', array(), array(), $this->headers);
        $response = $this->client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $tasks = json_decode($response->getContent(), true);
        $this->assertEquals(5, count($tasks));
    }

    public function testPostSuccessAction()
    {
        $params = [
            'subject' => 'New task',
            'priority' => 0,
        ];
        $this->client->request('POST', '/api/tasks', $params, [], $this->headers);
        $this->assertEquals($this->client->getResponse()->getStatusCode(), 302);
        $this->client->followRedirect();
        $this->assertResponse($this->client->getResponse(), 'task_added');
    }

    public function testPostNoPriorityAction()
    {
        $params = [
            'subject' => 'New task',
        ];
        $this->client->request('POST', '/api/tasks', $params, [], $this->headers);
        $this->assertResponse($this->client->getResponse(), 'new_task_no_priority', 400);
    }

    public function testGetSuccessAction()
    {
        $this->client->request('GET', '/api/tasks', array(), array(), $this->headers);
        $tasks = json_decode($this->client->getResponse()->getContent(), true);
        $id = $tasks[0]['id'];
        $this->client->request('GET', "/api/tasks/$id", [], [], $this->headers);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteSuccessAction()
    {
        $this->client->followRedirects(true);
        $params = [
            'subject' => 'New task',
            'priority' => 0,
        ];
        $this->client->request('POST', '/api/tasks', $params, [], $this->headers);
        $task = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(6, $this->getCollectionCount());
        $id = $task['id'];
        $this->client->request('DELETE', "/api/tasks/$id", [], [], $this->headers);
        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(5, $this->getCollectionCount());
    }

    private function getCollectionCount()
    {
        $this->client->request('GET', '/api/tasks', array(), array(), $this->headers);
        $tasks = json_decode($this->client->getResponse()->getContent(), true);

        return count($tasks);
    }
}
