<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\View\Helper;

use Laminas\Authentication\AuthenticationService;
use Psr\Container\ContainerInterface;

class LmcUserIdentityFactory
{
    public function __invoke(ContainerInterface $container): LmcUserIdentity
    {
        return new LmcUserIdentity(
            $container->get(AuthenticationService::class)
        );
    }
}
