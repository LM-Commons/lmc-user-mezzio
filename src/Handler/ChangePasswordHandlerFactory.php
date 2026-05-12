<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Authentication\AuthenticationService;
use Lmc\User\Mezzio\Options\Options;
use Lmc\User\Mezzio\Service\UserServiceInterface;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class ChangePasswordHandlerFactory
{
    public function __invoke(ContainerInterface $container): ChangePasswordHandler
    {
        return new ChangePasswordHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(AuthenticationService::class),
            $container->get(Options::class),
            $container->get('lmcuser_change_password_form'),
            $container->get(UserServiceInterface::class),
            $container->get(UrlHelper::class),
        );
    }
}