<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DayTypeControllerTest extends WebTestCase
{

    public function testList()
    {
        $data = $this->getJsonApiRepsonse('/day-type/');
        $this->assertEquals(5, count($data));
        $this->assertEquals($this->getExpected(), $this->findBy($data, 'id', 'relocated-working-day'));
    }

    public function testShow()
    {
        $data = $this->getJsonApiRepsonse('/day-type/relocated-working-day');
        $this->assertEquals($this->getExpected(), $data);
    }


    /**
     * @return array
     */
    private function getExpected(): array
    {
        return [
            'type' => 'day-type',
            'id' => 'relocated-working-day',
            'attributes' => [
                'key' => 'relocated-working-day',
                'name' => 'Áthelyezett munkanap',
                'is-rest-day' => false,
            ],
            'links' => [
                'self' => '/api/day-type/relocated-working-day'
            ],
        ];
    }

    /**
     * @param $url
     * @return array
     */
    private function getJsonApiRepsonse($url): array
    {
        $client = static::createClient();
        $client->request('GET', '/api' . $url);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        return json_decode($response->getContent(), true)['data'];
    }

    /**
     * @param array $array
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    private function findBy(array $array, $key, $value)
    {
        foreach ($array as $item) {
            if ($item[$key] === $value) {
                return $item;
            }
        }
    }
}
