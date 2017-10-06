<?php

namespace Tests\AppBundle\Controller;

/**
 * @group only
 */
class FunctionalTest extends ApiTestCase
{

    public function testProcess()
    {
        $empty = $this->getJsonApiRepsonse('/irregular-days/');
        $this->assertCount(0, $empty);

        $createResponseData = $this->postJsonApiRepsonse('/irregular-days/', $this->creationData());
        $this->assertEquals($this->getExpected(), $createResponseData);

        $data = $this->getJsonApiRepsonse('/irregular-days/');
        $this->assertCount(1, $data);
        $this->assertEquals($this->getExpected(), $this->findBy($data, 'id', '1'));

        $singleResponseData = $this->getJsonApiRepsonse('/irregular-days/1');
        $this->assertEquals($this->getExpected(), $singleResponseData);

        $draftPublicationData = $this->getJsonApiRepsonse('/publication/data');
        $this->assertEquals($this->getExpectedPublicationData(), $draftPublicationData);
    }

    /**
     * @return array
     */
    private function getExpected(): array
    {
        return [
            'type' => 'irregular-days',
            'id' => '1',
            'attributes' => [
                'date' => '2017-03-15T00:00:00+00:00',
                'description' => 'Forradalom',
                'type-key' => 'non-working-day'
            ],
            'links' => [
                'self' => '/api/irregular-days/1'
            ],
            'relationships' => [
                'day-type' => [
                    'data' => [
                        'type' => 'day-types',
                        'id' => 'non-working-day'
                    ]
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    private function creationData(): array
    {
        return [
            'data' => [
                'type' => 'irregularDays',
                'id' => 'undefined',
                'attributes' => [
                    'date' => '2017-03-15T00:00:00.000Z',
                    'description' => 'Forradalom',
                    'type-key' => 'non-working-day'
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function getExpectedPublicationData(): array
    {
        return [
            'type' => 'publication',
            'id' => 'data',
            'attributes' => [
                'publication-date' => null,
                'is-draft' => true
            ],
            'links' => [
                'self' => '/api/publication/data'
            ]
        ];
    }
}
