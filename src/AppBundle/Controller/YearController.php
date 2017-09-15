<?php

namespace AppBundle\Controller;

use AppBundle\JsonApi\JsonApi;
use AppBundle\Entity\Year;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/year")
 */
class YearController extends Controller
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
        $years = $this->getDoctrine()->getManager()->getRepository(Year::class)->findAll();
        return $this->jsonApi->response($years);
    }

    /**
     * @Route("/{year}", methods={"GET"})
     *
     * @param int $year
     * @return Response
     */
    public function showAction($year): Response
    {
        $year = $this->getDoctrine()->getManager()->getRepository(Year::class)->find($year);
        return $this->jsonApi->response($year);
    }
}
