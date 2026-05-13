<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Authentication\AuthenticationService;
use Lmc\User\Mezzio\Options\Options;
use Lmc\User\Mezzio\Service\UserServiceInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class ChangeEmailHandlerFactory
{
    public function __invoke(ContainerInterface $container): ChangeEmailHandler
    {
        return new ChangeEmailHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(AuthenticationService::class),
            $container->get(Options::class),
            $container->get('lmcuser_change_email_form'),
            $container->get(UserServiceInterface::class),
        );
    }
}