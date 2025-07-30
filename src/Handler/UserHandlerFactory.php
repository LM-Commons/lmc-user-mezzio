<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class UserHandlerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new UserHandler(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
