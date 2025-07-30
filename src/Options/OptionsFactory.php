<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Options;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class OptionsFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('config');
        if (! isset($config['lmc_user'])) {
            throw new ServiceNotCreatedException('Could not find a config for LmcUser');
        }
        return new Options($config['lmc_user']);
    }
}
