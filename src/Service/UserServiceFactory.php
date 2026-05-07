<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Service;

use Lmc\User\Mezzio\Exception\InvalidConfigurationException;
use Lmc\User\Mezzio\Options\Options;
use Lmc\User\Repository\AdapterInterface;
use MyProject\Container;
use Psr\Container\ContainerInterface;

class UserServiceFactory
{
    public function __invoke(ContainerInterface $container): UserService
    {
        /** @var AdapterInterface|null $mapper */
        $mapper = $container->has(AdapterInterface::class)
            ? $container->get(AdapterInterface::class)
            : null;

        if (null === $mapper) {
            throw new InvalidConfigurationException(
                'No User Repository adapter available. Did you forget to add a use repository library?'
            );
        }

        return new UserService(
            $mapper,
            $container->get('lmcuser_login_form'),
            $container->get('lmcuser_register_form'),
            $container->get('lmcuser_changepassword_form'),
            $container->get(Options::class),
            $container->get('lmcuser_register_form_hydrator'),
        );
    }
}
