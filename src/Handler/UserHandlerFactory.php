<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Lmc\User\Mezzio\Options\Options;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class UserHandlerFactory
{
    public function __invoke(ContainerInterface $container): UserHandler
    {
        return new UserHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(Options::class)
        );
    }
}
