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
                'lmcuser_login_form'             => Form\LoginForm::class,
                'lmcuser_register_form'          => Form\RegisterForm::class,
                'lmcuser_changepassword_form'    => Form\ChangePasswordForm::class,
                'lmcuser_register_form_hydrator' => 'lmcuser_user_hydrator', //this is defined by the user repository
            ],
            'factories'  => [
                Form\LoginForm::class               => Form\LoginFormFactory::class,
                Form\RegisterForm::class            => Form\RegisterFormFactory::class,
                Form\ChangePasswordForm::class      => Form\ChangePasswordFormFactory::class,
                Handler\LoginHandler::class         => Handler\LoginHandlerFactory::class,
                Handler\UserHandler::class          => Handler\UserHandlerFactory::class,
                Handler\LogoutHandler::class        => Handler\LogoutHandlerFactory::class,
                Handler\RegisterHandler::class      => Handler\RegisterHandlerFactory::class,
                Handler\RedirectCallback::class     => Handler\RedirectCallbackFactory::class,
                Helper\AuthenticationHelper::class  => Helper\AuthenticationHelperFactory::class,
                Service\UserServiceInterface::class => Service\UserServiceFactory::class,
                UserRepository::class               => UserRepositoryFactory::class,
                Options\Options::class              => Options\OptionsFactory::class,
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
