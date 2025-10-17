<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\View\Helper;

use Laminas\Authentication\AuthenticationServiceInterface;
use Psr\Container\ContainerInterface;

class LmcUserIdentityFactory
{
    public function __invoke(ContainerInterface $container): LmcUserIdentity
    {
        return new LmcUserIdentity(
            $container->get(AuthenticationServiceInterface::class)
        );
    }
}
