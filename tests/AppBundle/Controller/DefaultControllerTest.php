<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    public function testMain()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testStatus()
    {
        $client = static::createClient();

        $client->request('GET', '/status');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(['code' => 200, 'status' => 'ok'], $data);
    }
}
