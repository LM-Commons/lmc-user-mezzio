<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Mezzio\Application;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'view_helpers' => $this->getViewHelperConfig(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'    => [
                'lmcuser_login_form' => Form\LoginForm::class,
            ],
            'factories'  => [
                UserRepository::class              => UserRepositoryFactory::class,
                Options\Options::class             => Options\OptionsFactory::class,
                Handler\LoginHandler::class        => Handler\LoginHandlerFactory::class,
                Handler\UserHandler::class         => Handler\UserHandlerFactory::class,
                Handler\LogoutHandler::class       => Handler\LogoutHandlerFactory::class,
                Form\LoginForm::class              => Form\LoginFormFactory::class,
                Handler\RedirectCallback::class    => Handler\RedirectCallbackFactory::class,
                Helper\AuthenticationHelper::class => Helper\AuthenticationHelperFactory::class,
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

    private function getViewHelperConfig(): array
    {
        return [
            'factories' => [
                'lmcUserDisplayName' => View\Helper\LmcUserDisplayNameFactory::class,
                'lmcUserIdentity'    => View\Helper\LmcUserIdentityFactory::class,
                'lmcUserLoginWidget' => View\Helper\LmcUserLoginWidgetFactory::class,
            ],
        ];
    }
}
