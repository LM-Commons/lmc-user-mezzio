<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Lmc\User\Mezzio\Options\Options;
use Psr\Container\ContainerInterface;

class LoginFormFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): LoginForm
    {
        return new LoginForm(null, $container->get(Options::class));
    }
}
