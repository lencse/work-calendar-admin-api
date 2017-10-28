<?php

namespace AppBundle\Event;

use AppBundle\Auth\User;
use AppBundle\Auth\UserManager;
use AppBundle\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class KernelListener
{

    /**
     * @var string
     */
    private $frontendUrl;

    /**
     * @var Google
     */
    private $google;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var bool
     */
    private $authenticated = false;

    /**
     * @var string
     */
    private $message = 'Not authenticated';

    /**
     * @param $frontendUrl
     * @param Google $google
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        $frontendUrl,
        Google $google,
        EntityManagerInterface $entityManager,
        UserManager $userManager
    ) {
        $this->frontendUrl = $frontendUrl;
        $this->google = $google;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->getMethod() === 'OPTIONS') {
            $this->authenticated = true;
            return;
        }

        if (!preg_match('|^' . $request->getBaseUrl() . '/api/|', $request->getRequestUri())) {
            $this->authenticated = true;
            return;
        }

        $session = $request->getSession();
        if (!$session->has('auth_token')) {
            $this->message = 'No token';
            return;
        }

        $token = new AccessToken(['access_token' => $session->get('auth_token')]);

//        if (empty($token->getExpires())) {
//            $this->message = 'No expiration data';
//            return;
//        }
//
//        if ($token->hasExpired()) {
//            $this->message = 'Expired token';
//            return;
//        }

        try {
            $owner = $this->google->getResourceOwner($token);
        } catch (IdentityProviderException $e) {
            $session->remove('auth_token');
            return;
        }
        $email = $owner->getEmail();
        $entity = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['email' => $email]);
        if (!$entity) {
            $this->message = 'Invalid user';
            return;
        }

        $user = new User(
            $owner->getName(),
            $owner->getEmail(),
            $owner->getAvatar()
        );
        $this->userManager->loadCurrentUser($user);
        $this->authenticated = true;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        if (!$this->authenticated) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setContent(json_encode([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => $this->message,
            ]));
        }
        $response->headers->add([
            'Access-Control-Allow-Origin' => $this->frontendUrl,
            'Access-Control-Allow-Credentials' => 'true'
        ]);
    }
}
