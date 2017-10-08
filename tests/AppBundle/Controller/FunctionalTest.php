<?php

namespace Tests\AppBundle\Controller;

/**
 * @group only
 */
class FunctionalTest extends ApiTestCase
{

    public function testInitial()
    {
        $empty = $this->getJsonApiResponse('/irregular-days/');
        $this->assertCount(0, $empty);
    }

    /**
     * @depends testInitial
     */
    public function testFirstCreation()
    {
        $createResponseData = $this->postJsonApiRepsonse('/irregular-days/', $this->firstCreationData());
        $this->assertEquals($this->getExpected(), $createResponseData);

        $data = $this->getJsonApiResponse('/irregular-days/');
        $this->assertCount(1, $data);
        $this->assertEquals($this->getExpected(), $this->findBy($data, 'id', '1'));
    }

    /**
     * @depends testFirstCreation
     */
    public function testSingleResponse()
    {
        $singleResponseData = $this->getJsonApiResponse('/irregular-days/1');
        $this->assertEquals($this->getExpected(), $singleResponseData);
    }

    /**
     * @depends testSingleResponse
     */
    public function testDraftPublicationData()
    {
        $draftPublicationData = $this->getJsonApiResponse('/publication/data');
        $this->assertEquals($this->getExpectedDraftPublicationData(), $draftPublicationData);
    }

    /**
     * @depends testDraftPublicationData
     */
    public function testPublication()
    {
        $publishedPublicationData = $this->postJsonApiRepsonse('/publication/publish', []);
        $this->assertArrayHasKey('publication-date', $publishedPublicationData['attributes']);
        $date = $publishedPublicationData['attributes']['publication-date'];
        $this->assertEquals(1, preg_match('/^\d{4}-\d{2}-\d{2}.+$/', $date));
        unset($publishedPublicationData['attributes']['publication-date']);
        $this->assertEquals($this->getExpectedPublishedPublicationData(), $publishedPublicationData);
    }

    /**
     * @depends testPublication
     */
    public function testSecondCreation()
    {
        $this->postJsonApiRepsonse('/irregular-days/', $this->secondCreationData());

        $data = $this->getJsonApiResponse('/irregular-days/');
        $this->assertCount(2, $data);
    }

    /**
     * @depends testSecondCreation
     */
    public function testDraftAfterSecondCreation()
    {
        $draftPublicationData = $this->getJsonApiResponse('/publication/data');
        $this->assertArrayHasKey('publication-date', $draftPublicationData['attributes']);
        $date = $draftPublicationData['attributes']['publication-date'];
        $this->assertEquals(1, preg_match('/^\d{4}-\d{2}-\d{2}.+$/', $date));
        unset($draftPublicationData['attributes']['publication-date']);
        $this->assertEquals($this->getExpectedDraftPublicationDataWithPubDate(), $draftPublicationData);
    }

    /**
     * @depends testDraftAfterSecondCreation
     */
    public function testReset()
    {
        $resetPublicationData = $this->postJsonApiRepsonse('/publication/reset', []);
        $this->assertArrayHasKey('publication-date', $resetPublicationData['attributes']);
        $date = $resetPublicationData['attributes']['publication-date'];
        $this->assertEquals(1, preg_match('/^\d{4}-\d{2}-\d{2}.+$/', $date));
        unset($resetPublicationData['attributes']['publication-date']);
        $this->assertEquals($this->getExpectedPublishedPublicationData(), $resetPublicationData);
    }

    /**
     * @depends testReset
     */
    public function testUpdate()
    {
        $createResponseData = $this->putJsonApiRepsonse('/irregular-days/3', $this->updateData());
        $this->assertEquals($this->getUpdated(), $createResponseData);

        $data = $this->getJsonApiResponse('/irregular-days/');
        $this->assertCount(1, $data);
        $this->assertEquals($this->getUpdated(), $this->findBy($data, 'id', '3'));
    }

    /**
     * @depends testUpdate
     */
    public function testDelete()
    {
        $this->deleteJsonApiRepsonse('/irregular-days/3');

        $data = $this->getJsonApiResponse('/irregular-days/');
        $this->assertCount(0, $data);
    }

    public function testOptions()
    {
        $headers = $this->optionsRepsonse('/irregular-days/3');
        $this->assertEquals('OPTIONS, GET, PUT, DELETE', $headers->get('access-control-allow-methods'));
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
    private function getUpdated(): array
    {
        return [
            'type' => 'irregular-days',
            'id' => '3',
            'attributes' => [
                'date' => '2017-03-15T00:00:00+00:00',
                'description' => '1848-as forradalom',
                'type-key' => 'non-working-day'
            ],
            'links' => [
                'self' => '/api/irregular-days/3'
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
    private function firstCreationData(): array
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
    private function updateData(): array
    {
        return [
            'data' => [
                'type' => 'irregularDays',
                'id' => 'undefined',
                'attributes' => [
                    'date' => '2017-03-15T00:00:00.000Z',
                    'description' => '1848-as forradalom',
                    'type-key' => 'non-working-day'
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function secondCreationData(): array
    {
        return [
            'data' => [
                'type' => 'irregularDays',
                'id' => 'undefined',
                'attributes' => [
                    'date' => '2017-03-18T00:00:00.000Z',
                    'description' => 'x',
                    'type-key' => 'relocated-working-day'
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function getExpectedDraftPublicationData(): array
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

    /**
     * @return array
     */
    private function getExpectedDraftPublicationDataWithPubDate(): array
    {
        return [
            'type' => 'publication',
            'id' => 'data',
            'attributes' => [
                'is-draft' => true
            ],
            'links' => [
                'self' => '/api/publication/data'
            ]
        ];
    }

    /**
     * @return array
     */
    private function getExpectedPublishedPublicationData(): array
    {
        return [
            'type' => 'publication',
            'id' => 'data',
            'attributes' => [
                'is-draft' => false
            ],
            'links' => [
                'self' => '/api/publication/data'
            ]
        ];
    }
}
