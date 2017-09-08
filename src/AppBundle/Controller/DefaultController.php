<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/status")
     */
    public function statusAction()
    {
        return $this->json([
            'code' => Response::HTTP_OK,
            'status' => 'ok'
        ]);
    }
}
