<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Tests\AppBundle\AppSetup;

abstract class ApiTestCase extends WebTestCase
{
    /**
     * Redeclared as public
     *
     * @inheritdoc
     */
    public static function createKernel(array $options = array())
    {
        return parent::createKernel($options);
    }

    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        AppSetup::setupDb();
    }

    /**
     * @param $url
     * @return array
     */
    protected function getJsonApiRepsonse($url): array
    {
        $client = $this->getClient();
        $client->request('GET', '/api' . $url);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        return json_decode($response->getContent(), true)['data'];
    }

    /**
     * @param $url string
     * @param array $data
     * @return array
     */
    protected function postJsonApiRepsonse($url, array $data): array
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            '/api/irregular-days/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

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
    protected function findBy(array $array, $key, $value)
    {
        foreach ($array as $item) {
            if ($item[$key] === $value) {
                return $item;
            }
        }
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return static::createClient();
    }
}
