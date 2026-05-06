<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Authentication\AuthenticationService;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class RegisterHandlerFactory
{
    public function __invoke(ContainerInterface $container): RegisterHandler
    {
        return new RegisterHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(AuthenticationService::class),
            $container->get(Options::class),
            $container->get('lmcuser_register_form'),
            $container->get(UrlHelper::class),
        );
    }
}