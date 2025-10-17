<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Helper;

use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Psr\Container\ContainerInterface;

class AuthenticationHelperFactory
{
    public function __invoke(ContainerInterface $container): AuthenticationHelper
    {
        return new AuthenticationHelper(
            $container->get(AuthenticationServiceInterface::class),
            $container->get(AdapterInterface::class)
        );
    }
}
