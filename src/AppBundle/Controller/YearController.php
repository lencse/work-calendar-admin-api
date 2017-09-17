<?php

namespace AppBundle\Controller;

use AppBundle\JsonApi\JsonApi;
use AppBundle\Entity\Year;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/years")
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
     * @Route("/", methods={"POST"})
     *
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $year = new Year();
        $data = json_decode($request->getContent(), true)['data'];
        $year->setYear($data['attributes']['year']);
        $year->setIsEnabled($data['attributes']['is-enabled']);
        $this->getDoctrine()->getManager()->persist($year);
        $this->getDoctrine()->getManager()->flush();
        return $this->jsonApi->response($year);
    }

    /**
     * @Route("/{year}")
     * @Method("GET")
     *
     * @param int $year
     * @return Response
     */
    public function showAction($year): Response
    {
        $year = $this->getDoctrine()->getManager()->getRepository(Year::class)->find($year);
        return $this->jsonApi->response($year);
    }

    /**
     * @Route("/{year}")
     * @Method("PUT")
     *
     * @param int $year
     * @return Response
     */
    public function updateAction(Request $request, $year): Response
    {
        $year = $this->getDoctrine()->getManager()->getRepository(Year::class)->find($year);
        $data = json_decode($request->getContent(), true)['data'];
        $year->setIsEnabled($data['attributes']['is-enabled']);
        $this->getDoctrine()->getManager()->persist($year);
        $this->getDoctrine()->getManager()->flush();
        return $this->jsonApi->response($year);
    }

    /**
     * @Route("/{year}")
     * @Method("OPTIONS")
     *
     * @param int $year
     * @return Response
     */
    public function optionsAction($year): Response
    {
        return new Response('', Response::HTTP_OK, [
            'Access-Control-Allow-Methods' => 'OPTIONS, GET, PUT',
            'Allow' => 'OPTIONS, GET, PUT'
        ]);
    }
}
