<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Lmc\User\Mezzio\Options\Options;
use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;

class RedirectCallbackFactory
{
    public function __invoke(ContainerInterface $container): RedirectCallback
    {
        return new RedirectCallback(
            $container->get(Options::class),
            $container->get(RouterInterface::class),
        );
    }
}
