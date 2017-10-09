<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Tests\AppBundle\Controller\ApiTestCase;

class AppSetup
{

    /**
     * @var Application
     */
    private static $app;

    public static function setupDb(): void
    {
        if (!empty(self::$app)) {
            return;
        }

        self::$app = new Application(ApiTestCase::createKernel());
        self::$app->setAutoExit(false);
        self::$app->run(new ArrayInput(['doctrine:database:drop', '--force' => true]));
        self::$app->run(new ArrayInput(['doctrine:schema:update', '--force' => true]));
    }
}
