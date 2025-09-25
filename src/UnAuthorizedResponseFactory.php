<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\User\Mezzio\Options\Options;
use Mezzio\Helper\UrlHelperInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class UnAuthorizedResponseFactory
{
    public function __invoke(ContainerInterface $container): UnauthorizedResponse
    {
        return new UnauthorizedResponse(
            $container->get(UrlHelperInterface::class),
            $container->get(ResponseFactoryInterface::class),
            $container->get(Options::class)
        );
    }
}
