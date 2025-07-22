<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthenticationFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Authentication
    {
        return new Authentication(
            $container->get(ResponseFactoryInterface::class),
        );
    }
}
