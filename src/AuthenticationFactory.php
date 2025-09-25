<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\User\Repository\AdapterInterface;
use Psr\Container\ContainerInterface;

class AuthenticationFactory
{
    public function __invoke(ContainerInterface $container): Authentication
    {
        return new Authentication(
            $container->get(AdapterInterface::class),
            $container->get(UserRepository::class),
        );
    }
}
