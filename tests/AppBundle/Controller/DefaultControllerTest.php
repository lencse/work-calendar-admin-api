<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

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
