<?php

namespace AppBundle\Controller;

use AppBundle\JsonApi\JsonApi;
use Lencse\WorkCalendar\Api\JsonApi\DayTypeSchema;
use Lencse\WorkCalendar\Day\DayType;
use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Http\Headers\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/day-type")
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
     * @Route("/")
     *
     * @return Response
     */
    public function listAction(): Response
    {
        return $this->jsonApi->response(DayType::getAllTypes());
    }

    /**
     * @Route("/{key}")
     *
     * @param string $key
     * @return Response
     */
    public function showAction($key): Response
    {
        return $this->jsonApi->response(DayType::get($key));
    }
}
