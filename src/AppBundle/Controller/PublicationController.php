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
        $data = $this->getDoctrine()->getManager()->getRepository(PublicationData::class)->getPublicationData();
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
        $data = $em->getRepository(PublicationData::class)->getPublicationData();
        $toDelete = $em->getRepository(IrregularDayEntity::class)->findBy(['isPublished' => true]);
        foreach ($toDelete as $item) {
            $em->remove($item);
        }
        $em->flush();

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
    /**
     * @Route("/reset", methods={"POST"})
     *
     * @return Response
     */
    public function resetAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(PublicationData::class)->getPublicationData();
        $toDelete = $em->getRepository(IrregularDayEntity::class)->findBy(['isPublished' => false]);
        foreach ($toDelete as $item) {
            $em->remove($item);
        }
        $em->flush();

        $toDraft = $em->getRepository(IrregularDayEntity::class)->findBy(['isPublished' => true]);
        foreach ($toDraft as $published) {
            $draft = new IrregularDayEntity();
            $draft->setIsPublished(false)
                ->setDate($published->getDate())
                ->setDescription($published->getDescription())
                ->setTypeKey($published->getTypeKey());
            $em->persist($draft);
        }

        $data->setIsDraft(false);
        $em->persist($data);

        $em->flush();

        return $this->jsonApi->response($data);
    }
}
