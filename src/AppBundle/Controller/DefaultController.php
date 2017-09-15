<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/")
     *
     * @return Response
     */
    public function mainRouteAction(): Response
    {
        return $this->redirectToRoute('app_default_status');
    }

    /**
     * @Route("/status", methods={"GET"})
     *
     * @return Response
     */
    public function statusAction(): Response
    {
        return $this->json([
            'code' => Response::HTTP_OK,
            'status' => 'ok'
        ]);
    }
}
