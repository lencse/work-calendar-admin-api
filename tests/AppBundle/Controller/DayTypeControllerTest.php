<?php

namespace Tests\AppBundle\Controller;

class DayTypeControllerTest extends ApiTestCase
{

    public function testList()
    {
        $data = $this->getJsonApiRepsonse('/day-types/');
        $this->assertCount(3, $data);
        $this->assertEquals($this->getExpected(), $this->findBy($data, 'id', 'relocated-working-day'));
    }

    public function testShow()
    {
        $data = $this->getJsonApiRepsonse('/day-types/relocated-working-day');
        $this->assertEquals($this->getExpected(), $data);
    }

    /**
     * @return array
     */
    private function getExpected(): array
    {
        return [
            'type' => 'day-types',
            'id' => 'relocated-working-day',
            'attributes' => [
                'key' => 'relocated-working-day',
                'name' => 'Áthelyezett munkanap',
                'is-rest-day' => false,
            ],
            'links' => [
                'self' => '/api/day-types/relocated-working-day'
            ],
        ];
    }
}
