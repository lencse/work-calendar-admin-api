<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DayTypeControllerTest extends WebTestCase
{

    public function testList()
    {
        $client = static::createClient();

        $client->request('GET', '/day-type/');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true)['data'];

        $this->assertEquals(5, count($data));
        foreach ($data as $item) {
            if ($item['id'] === 'relocated-working-day') {
                $expected = [
                    'type' => 'day-type',
                    'id' => 'relocated-working-day',
                    'attributes' => [
                        'key' => 'relocated-working-day',
                        'name' => 'Áthelyezett munkanap',
                        'is-rest-day' => false,
                    ]
                ];
                $this->assertEquals($expected, $item);
            }
        }
    }
}
