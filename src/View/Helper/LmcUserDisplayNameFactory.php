<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\View\Helper;

use Laminas\Authentication\AuthenticationServiceInterface;
use Psr\Container\ContainerInterface;

class LmcUserDisplayNameFactory
{
    public function __invoke(ContainerInterface $container): LmcUserDisplayName
    {
        return new LmcUserDisplayName(
            $container->get(AuthenticationServiceInterface::class)
        );
    }
}
