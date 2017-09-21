<?php

namespace AppBundle\Controller;

use AppBundle\JsonApi\JsonApi;
use AppBundle\Entity\ActiveYear;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/active-years")
 */
class ActiveYearController extends Controller
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
        $years = $this->getDoctrine()->getManager()->getRepository(ActiveYear::class)->findAll();
        return $this->jsonApi->response($years);
    }

    /**
     * @Route("/", methods={"POST"})
     *
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $year = new ActiveYear();
        $data = json_decode($request->getContent(), true)['data'];
        $year->setYear($data['attributes']['year']);
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
        $year = $this->getDoctrine()->getManager()->getRepository(ActiveYear::class)->find($year);
        return $this->jsonApi->response($year);
    }

    /**
     * @Route("/{year}")
     * @Method("DELETE")
     *
     * @param int $year
     * @return Response
     */
    public function deleteAction(Request $request, $year): Response
    {
        $year = $this->getDoctrine()->getManager()->getRepository(ActiveYear::class)->find($year);
        $this->getDoctrine()->getManager()->remove($year);
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
            'Access-Control-Allow-Methods' => 'OPTIONS, GET, POST, DELETE',
            'Allow' => 'OPTIONS, GET, POST, DELETE'
        ]);
    }
}
