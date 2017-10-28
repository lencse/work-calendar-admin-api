<?php

namespace AppBundle\Controller;

use AppBundle\Auth\User;
use AppBundle\Auth\UserManager;
use AppBundle\JsonApi\JsonApi;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Token\AccessToken;
use Lencse\WorkCalendar\Day\DayType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/user")
 */
class UserController extends Controller
{

    /**
     * @var JsonApi
     */
    private $jsonApi;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @param JsonApi $jsonApi
     * @param UserManager $userManager
     */
    public function __construct(JsonApi $jsonApi, UserManager $userManager)
    {
        $this->jsonApi = $jsonApi;
        $this->userManager = $userManager;
    }

    /**
     * @Route("/me", methods={"GET"})
     *
     * @return Response
     */
    public function getDataAction(): Response
    {
        $data = $this->userManager->getCurrentUser();
        return $this->jsonApi->response($data);
    }
}
