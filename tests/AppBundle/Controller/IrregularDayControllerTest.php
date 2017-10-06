<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * @group only
 */
class IrregularDayControllerTest extends WebTestCase
{

    public function testList()
    {
        $app = new Application(static::createKernel());
        $app->setAutoExit(false);
        $app->run(new ArrayInput(['doctrine:schema:update', '--force' => true]));
        $data = $this->getJsonApiRepsonse('/irregular-days/');
        $this->assertCount(0, $data);
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
