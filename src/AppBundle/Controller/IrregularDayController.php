<?php

namespace AppBundle\Controller;

use AppBundle\JsonApi\IrregularDaySchema;
use AppBundle\JsonApi\JsonApi;
use AppBundle\Entity\IrregularDayEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/api/irregular-days")
 */
class IrregularDayController extends Controller
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
//        $date = \DateTime::createFromFormat('Y-m-d', substr('2017-09-15T00:00:00.000Z', 0, 10));
//        dump($date); exit;

//'2004-02-12T15:19:21+00:00';
//'2017-09-06T00:00:00.000Z';


//        dump(\DateTime::createFromFormat(\DateTime::ISO8601, '2004-02-12T15:19:21+00:00')); exit;
//        dump(\DateTime::createFromFormat('Y-m-d', substr('2017-09-06T00:00:00.000Z', 0, 10))); exit;
        $days = $this->getDoctrine()->getManager()->getRepository(IrregularDayEntity::class)->findAll();
        return $this->jsonApi->response($days);
    }

    /**
     * @Route("/", methods={"POST"})
     *
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $day = new IrregularDayEntity();
        $data = json_decode($request->getContent(), true)['data'];
        $date = \DateTime::createFromFormat('Y-m-d', substr($data['attributes']['date'], 0, 10));
        $date->setTime(0, 0, 0);
        $day->setDate($date);
        $day->setTypeKey($data['attributes']['type-key']);
        $day->setDescription(isset($data['attributes']['description']) ? $data['attributes']['description'] : '');
        $this->getDoctrine()->getManager()->persist($day);
        $this->getDoctrine()->getManager()->flush();
        return $this->jsonApi->response($day);
    }

    /**
     * @Route("/{id}")
     * @Method("GET")
     *
     * @param int $id
     * @return Response
     */
    public function showAction($id): Response
    {
        $day = $this->getDoctrine()->getManager()->getRepository(IrregularDayEntity::class)->find($id);
        return $this->jsonApi->response($day);
    }
//
//    /**
//     * @Route("/{year}")
//     * @Method("PUT")
//     *
//     * @param int $year
//     * @return Response
//     */
//    public function updateAction(Request $request, $year): Response
//    {
//        $year = $this->getDoctrine()->getManager()->getRepository(Year::class)->find($year);
//        $data = json_decode($request->getContent(), true)['data'];
//        $year->setIsEnabled($data['attributes']['is-enabled']);
//        $this->getDoctrine()->getManager()->persist($year);
//        $this->getDoctrine()->getManager()->flush();
//        return $this->jsonApi->response($year);
//    }
//
//    /**
//     * @Route("/{year}")
//     * @Method("OPTIONS")
//     *
//     * @param int $year
//     * @return Response
//     */
//    public function optionsAction($year): Response
//    {
//        return new Response('', Response::HTTP_OK, [
//            'Access-Control-Allow-Methods' => 'OPTIONS, GET, PUT',
//            'Allow' => 'OPTIONS, GET, PUT'
//        ]);
//    }
}
