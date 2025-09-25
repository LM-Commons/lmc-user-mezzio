<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class UserHandlerFactory
{
    public function __invoke(ContainerInterface $container): UserHandler
    {
        return new UserHandler(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
