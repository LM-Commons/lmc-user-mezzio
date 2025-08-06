<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Lmc\User\Repository\AdapterInterface;
use Psr\Container\ContainerInterface;

class AuthenticationFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Authentication
    {
        return new Authentication(
            $container->get(AdapterInterface::class),
            $container->get(UserRepository::class),
        );
    }
}
