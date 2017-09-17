<?php

namespace AppBundle\Controller;

use AppBundle\JsonApi\JsonApi;
use Lencse\WorkCalendar\Day\DayType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/day-types")
 */
class DayTypeController extends Controller
{

    /**
     * @var JsonApi
     */
    private $jsonApi;

    /**
     * @param JsonApi $jsonApi
     */
    public function __construct(JsonApi $jsonApi)
    {
        $this->jsonApi = $jsonApi;
    }

    /**
     * @Route("/", methods={"GET"})
     *
     * @return Response
     */
    public function listAction(): Response
    {
        return $this->jsonApi->response(DayType::getIrregulars());
    }

    /**
     * @Route("/{key}", methods={"GET"})
     *
     * @param string $key
     * @return Response
     */
    public function showAction($key): Response
    {
        return $this->jsonApi->response(DayType::get($key));
    }
}
