<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Lmc\User\Mezzio\Handler\LoginHandler;
use Lmc\User\Mezzio\Handler\LogoutHandler;
use Lmc\User\Mezzio\Handler\UserHandler;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Application;
use Mezzio\Authentication\AuthenticationMiddleware;
use Psr\Container\ContainerInterface;

use function assert;
use function sprintf;

class RoutesDelegator implements DelegatorFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null)
    {
        /** @var Options $lmcuserOptions */
        $lmcuserOptions = $container->get(Options::class);
        $application    = $callback();
        assert($application instanceof Application);

        $application->get(
            sprintf('%s%s', $lmcuserOptions->getBasePath(), '/user'),
            [
                AuthenticationMiddleware::class,
                UserHandler::class,
            ],
            'lmcuser'
        );
        $application->route(
            sprintf('%s%s', $lmcuserOptions->getBasePath(), '/login'),
            [LoginHandler::class],
            ['GET', 'POST'],
            'lmcuser.login'
        );

        $application->get(
            sprintf('%s%s', $lmcuserOptions->getBasePath(), '/logout'),
            [LogoutHandler::class],
            'lmcuser.logout'
        );

        return $application;
    }
}
