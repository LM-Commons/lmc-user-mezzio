<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Laminas\Router\Http\Literal;
use Lmc\User\Mezzio\Handler\LoginHandler;
use Lmc\User\Mezzio\Handler\UserHandler;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes'       => $this->getRouterConfig(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                Authentication::class  => AuthenticationFactory::class,
                UserRepository::class  => UserRepositoryFactory::class,
                Options\Options::class => Options\OptionsFactory::class,
                LoginHandler::class    => Handler\LoginHandlerFactory::class,
                UserHandler::class     => Handler\UserHandlerFactory::class,
            ],
        ];
    }

    public function getRouterConfig(): array
    {
        return [
            'lmcuser'       => [
                'methods'    => ['GET'],
                'middleware' => [
                    UserHandler::class,
                ],
                'path'       => '/user',
                'type'       => Literal::class,
                'options'    => [],
            ],
            'lmcuser.login' => [
                'type'       => Literal::class,
                'methods'    => ['GET'],
                'options'    => [],
                'path'       => '/login',
                'middleware' => [
                    LoginHandler::class,
                ],
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'lmcuser' => [__DIR__ . '/../templates/lmcuser'],
            ],
        ];
    }
}
