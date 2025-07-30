<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Lmc\User\Mezzio\Authentication;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Helper\UrlHelper;
use Psr\Container\ContainerInterface;

class LogoutHandlerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): LogoutHandler
    {
        return new LogoutHandler(
            $container->get(Authentication::class),
            $container->get(Options::class),
            $container->get(UrlHelper::class)
        );
    }
}
