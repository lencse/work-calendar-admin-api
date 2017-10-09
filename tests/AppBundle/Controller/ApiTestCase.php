<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
    protected function getJsonApiResponse($url): array
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
            '/api' . $url,
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
     * @param $url string
     * @param array $data
     * @return array
     */
    protected function putJsonApiRepsonse($url, array $data): array
    {
        $client = $this->getClient();
        $client->request(
            'PUT',
            '/api' . $url,
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
     * @param $url string
     * @return void
     */
    protected function deleteJsonApiRepsonse($url): void
    {
        $client = $this->getClient();
        $client->request('DELETE', '/api' . $url);

        $response = $client->getResponse();
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * @param $url string
     * @return ResponseHeaderBag
     */
    protected function optionsRepsonse($url): ResponseHeaderBag
    {
        $client = $this->getClient();
        $client->request('OPTIONS', '/api' . $url);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        return $response->headers;
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
