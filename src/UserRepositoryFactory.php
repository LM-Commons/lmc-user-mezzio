<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\User\Mezzio\Options\Options;
use Lmc\User\Repository\AdapterInterface;
use Psr\Container\ContainerInterface;

class UserRepositoryFactory
{
    public function __invoke(ContainerInterface $container): UserRepository
    {
        return new UserRepository(
            $container->get(AdapterInterface::class),
            $container->get(Options::class),
        );
    }
}
