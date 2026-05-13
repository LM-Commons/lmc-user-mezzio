<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Lmc\Authentication\AuthenticationMiddleware;
use Lmc\User\Mezzio\Handler\ChangeEmailHandler;
use Lmc\User\Mezzio\Handler\ChangePasswordHandler;
use Lmc\User\Mezzio\Handler\LoginHandler;
use Lmc\User\Mezzio\Handler\LogoutHandler;
use Lmc\User\Mezzio\Handler\RegisterHandler;
use Lmc\User\Mezzio\Handler\UserHandler;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Application;
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

        $application->route(
            sprintf('%s%s', $lmcuserOptions->getBasePath(), '/register'),
            [RegisterHandler::class],
            ['GET', 'POST'],
            'lmcuser.register'
        );

        $application->route(
            sprintf('%s%s', $lmcuserOptions->getBasePath(), '/change-password'),
            [ChangePasswordHandler::class],
            ['GET', 'POST'],
            'lmcuser.change_password'
        );

        $application->route(
            sprintf('%s%s', $lmcuserOptions->getBasePath(), '/change-email'),
            [ChangeEmailHandler::class],
            ['GET', 'POST'],
            'lmcuser.change_email'
        );

        return $application;
    }
}
