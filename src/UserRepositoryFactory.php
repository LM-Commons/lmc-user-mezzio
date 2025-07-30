<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Lmc\User\Common\Mapper\UserMapperInterface;
use Lmc\User\Mezzio\Options\Options;
use Psr\Container\ContainerInterface;

class UserRepositoryFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): UserRepository
    {
        return new UserRepository(
            $container->get(UserMapperInterface::class),
            $container->get(Options::class),
        );
    }
}
