<?php

namespace AppBundle\Controller;

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
     * @Route("/auth")
     *
     * @return Response
     */
    public function PreAuthAction(Request $request): Response
    {
        $provider = new Google([
            'clientId' => '471125045048-jf7tugslk64efdhpp9fo3khei0spb0op.apps.googleusercontent.com',
            'clientSecret' => 'cwhxC_4FF8NVFvTrUANEr56G',
            'redirectUri' => 'http://localhost:8210/app_dev.php/auth/callback',
            'hostedDomain' => 'http://localhost:8211',
        ]);
        $authUrl = $provider->getAuthorizationUrl();

        $request->getSession()->set('oauth2state', $provider->getState());

        return $this->redirect($authUrl);
    }

    /**
     * @Route("/callback")
     *
     * @return Response
     */
    public function authAction(Request $request): Response
    {
        if (!empty($request->get('error'))) {
            echo $request->get('error'); exit;
        }
        $session = $request->getSession();
//        dump($session); exit;
//        $session->migrate();
        if (empty($request->get('state')) || $session->get('oauth2state') !== $request->get('state')) {
            $session->remove('oauth2state');
            echo 'Invalid state'; exit;
        }
        $provider = new Google([
            'clientId' => '471125045048-jf7tugslk64efdhpp9fo3khei0spb0op.apps.googleusercontent.com',
            'clientSecret' => 'cwhxC_4FF8NVFvTrUANEr56G',
            'redirectUri' => 'http://localhost:8210/app_dev.php/auth/callback',
            'hostedDomain' => 'http://localhost:8211',
        ]);
        $token = $provider->getAccessToken('authorization_code', ['code' => $request->get('code')]);
//        $provider->getAccessToken() $token->getToken()
//        $request->getSession()->set('auth_token', $token->getToken())
//        /** @var GoogleUser $owner */
//        $owner = $provider->getResourceOwner($token);
//
//        dump([
//            $token->getToken(),
//            $token->getRefreshToken(),
//            $token->getExpires()
//        ]); exit;
//        echo '<p>' . $owner->getEmail() . '</p><p>' . $owner->getName() . '</p><p><img src="' . $owner->getAvatar() . '"></p>'; exit;
    }
}