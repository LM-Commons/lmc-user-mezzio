<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\User\Mezzio\Form\LoginForm;
use Lmc\User\Mezzio\Form\LoginFormFactory;
use Mezzio\Application;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'    => [
                'lmcuser_login_form' => LoginForm::class,
            ],
            'factories'  => [
                Authentication::class        => AuthenticationFactory::class,
                UserRepository::class        => UserRepositoryFactory::class,
                Options\Options::class       => Options\OptionsFactory::class,
                Handler\LoginHandler::class  => Handler\LoginHandlerFactory::class,
                Handler\UserHandler::class   => Handler\UserHandlerFactory::class,
                Handler\LogoutHandler::class => Handler\LogoutHandlerFactory::class,
                LoginForm::class             => LoginFormFactory::class,
            ],
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
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
