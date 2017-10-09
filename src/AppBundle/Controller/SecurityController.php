<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="wcadmin_security_login")
     *
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        dump($request->get('email'));
        $error = $authUtils->getLastAuthenticationError();
//        dump($this->get('translator')); exit;
        return $this->render('::login.html.twig', ['error' => $error]);
    }

    /**
     * @Route("/login-check", name="wcadmin_security_login_check")
     *
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginCheckAction(Request $request, AuthenticationUtils $authUtils)
    {
        dump($_POST); exit;
    }

    /**
     * @Route("/logout", name="wcadmin_security_logout")
     */
    public function logout()
    {
    }
}
