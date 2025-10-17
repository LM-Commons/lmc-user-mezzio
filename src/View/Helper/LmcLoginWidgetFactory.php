<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\View\Helper;

use Lmc\User\Mezzio\Options\Options;
use Psr\Container\ContainerInterface;

class LmcLoginWidgetFactory
{
    public function __invoke(ContainerInterface $container): LmcUserLoginWidget
    {
        /** @var Options $options */
        $options = $container->get(Options::class);
        return new LmcUserLoginWidget(
            $container->get('lmcuser_login_form'),
            $options->getUserLoginWidgetViewTemplate()
        );
    }
}
