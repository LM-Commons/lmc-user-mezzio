<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Form\FormInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class LoginHandlerFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new LoginHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(AuthenticationInterface::class),
            $container->get(Options::class),
            $container->get('lmcuser_login_form')
        );
    }
}
