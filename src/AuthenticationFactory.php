<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Lmc\User\Common\Mapper\UserMapperInterface;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Authentication\UserInterface;
use Mezzio\Helper\UrlHelperInterface;
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
            $container->get(UrlHelperInterface::class),
            $container->get(ResponseFactoryInterface::class),
            $container->get(Options::class),
            $container->get(UserMapperInterface::class),
            $container->get(UserInterface::class),
            $container->get(UserRepository::class)
        );
    }
}
