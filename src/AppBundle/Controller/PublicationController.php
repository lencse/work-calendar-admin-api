<?php

namespace AppBundle\Controller;

use AppBundle\Entity\IrregularDayEntity;
use AppBundle\Entity\PublicationData;
use AppBundle\JsonApi\JsonApi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/api/publication")
 */
class PublicationController extends Controller
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
     * @Route("/data", methods={"GET"})
     *
     * @return Response
     */
    public function getDataAction(): Response
    {
        $data = $this->getDoctrine()->getManager()->getRepository(PublicationData::class)->find(1);
        return $this->jsonApi->response($data);
    }

    /**
     * @Route("/publish", methods={"POST"})
     *
     * @return Response
     */
    public function publishAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(PublicationData::class)->find(1);
        $toDelete = $em->getRepository(IrregularDayEntity::class)->findBy(['isPublished' => true]);
        foreach ($toDelete as $item) {
            $em->remove($item);
        }
        $toPublish = $em->getRepository(IrregularDayEntity::class)->findBy(['isPublished' => false]);
        foreach ($toPublish as $draft) {
            $published = new IrregularDayEntity();
            $published->setIsPublished(true)
                ->setDate($draft->getDate())
                ->setDescription($draft->getDescription())
                ->setTypeKey($draft->getTypeKey());
            $em->persist($published);
        }

        $data->setPublicationDate(new \DateTime());
        $data->setIsDraft(false);
        $em->persist($data);

        $em->flush();

        return $this->jsonApi->response($data);
    }

//    /**
//     * @Route("/", methods={"POST"})
//     *
//     * @return Response
//     */
//    public function createAction(Request $request): Response
//    {
//        $day = new IrregularDayEntity();
//        $data = json_decode($request->getContent(), true)['data'];
//        $date = \DateTime::createFromFormat('Y-m-d', substr($data['attributes']['date'], 0, 10));
//        $date->setTime(0, 0);
//        $day->setDate($date);
//        $day->setTypeKey($data['attributes']['type-key']);
//        $day->setIsPublished(false);
//        $day->setDescription(isset($data['attributes']['description']) ? $data['attributes']['description'] : '');
//        $this->getDoctrine()->getManager()->persist($day);
//        $this->getDoctrine()->getManager()->flush();
//        return $this->jsonApi->response($day);
//    }
//
//    /**
//     * @Route("/{id}")
//     * @Method("GET")
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function showAction($id): Response
//    {
//        $day = $this->getDoctrine()->getManager()->getRepository(IrregularDayEntity::class)->find($id);
//        return $this->jsonApi->response($day);
//    }
//
//    /**
//     * @Route("/{id}")
//     * @Method("PUT")
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function updateAction(Request $request, $id): Response
//    {
//        $day = $this->getDoctrine()->getManager()->getRepository(IrregularDayEntity::class)->find($id);
//        $data = json_decode($request->getContent(), true)['data'];
//        $date = \DateTime::createFromFormat('Y-m-d', substr($data['attributes']['date'], 0, 10));
//        $day->setTypeKey($data['attributes']['type-key']);
//        $day->setDescription($data['attributes']['description']);
//        $day->setDate($date);
//        $day->setTypeKey($data['attributes']['type-key']);
//        $this->getDoctrine()->getManager()->persist($day);
//        $this->getDoctrine()->getManager()->flush();
//        return $this->jsonApi->response($day);
//    }
//
//    /**
//     * @Route("/{id}")
//     * @Method("DELETE")
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function deleteAction($id): Response
//    {
//        $day = $this->getDoctrine()->getManager()->getRepository(IrregularDayEntity::class)->find($id);
//        $this->getDoctrine()->getManager()->remove($day);
//        $this->getDoctrine()->getManager()->flush();
//        return new Response(null, Response::HTTP_NO_CONTENT);
//    }
//
//    /**
//     * @Route("/{id}")
//     * @Method("OPTIONS")
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function optionsAction($id): Response
//    {
//        return new Response('', Response::HTTP_OK, [
//            'Access-Control-Allow-Methods' => 'OPTIONS, GET, PUT, DELETE',
//        ]);
//    }
}
