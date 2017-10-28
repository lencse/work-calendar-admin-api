<?php

namespace AppBundle\Controller;

use AppBundle\Auth\UserManager;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\GoogleUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/auth")
 */
class AuthController extends Controller
{

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var Google
     */
    private $google;

    /**
     * @param UserManager $userManager
     * @param Google $google
     */
    public function __construct(UserManager $userManager, Google $google)
    {
        $this->userManager = $userManager;
        $this->google = $google;
    }

    /**
     * @Route("/auth")
     *
     * @return Response
     */
    public function authAction(Request $request): Response
    {
        $authUrl = $this->google->getAuthorizationUrl();
        $request->getSession()->set('oauth2state', $this->google->getState());
//        dump([$this->google->getState(), $request->getSession()->get('oauth2state')]);
//        echo '<a href="' . $authUrl . '">Katt</a>'; exit;
        return $this->redirect($authUrl);
    }

    /**
     * @Route("/callback")
     *
     * @return Response
     */
    public function callbackAction(Request $request): Response
    {
        if (!empty($request->get('error'))) {
            echo $request->get('error'); exit;
        }
        $session = $request->getSession();
        if (empty($request->get('state')) || $session->get('oauth2state') !== $request->get('state')) {
            $session->remove('oauth2state');
            echo 'Invalid state'; exit;
        }
        $token = $this->google->getAccessToken('authorization_code', ['code' => $request->get('code')]);
        $session->set('auth_token', $token->getToken());
//        dump([$token->getExpires(), $token->getValues(), $token->getToken()]); exit;

        return $this->redirect($this->userManager->getFrontendUrl());
    }

    /**
     * @Route("/logout")
     */
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('auth_token');
        $session->remove('oauth2state');

        return $this->redirectToRoute('app_auth_auth');
    }
}
