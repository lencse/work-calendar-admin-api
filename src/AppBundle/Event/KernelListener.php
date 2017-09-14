<?php

namespace AppBundle\Event;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class KernelListener
{

    /**
     * @var string
     */
    private $frontendUrl;

    /**
     * @param string $frontendUrl
     */
    public function __construct($frontendUrl)
    {
        $this->frontendUrl = $frontendUrl;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->add([
            'Access-Control-Allow-Origin' => $this->frontendUrl
        ]);
    }
}
