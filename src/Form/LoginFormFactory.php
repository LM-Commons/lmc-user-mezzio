<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Lmc\User\Mezzio\Options\Options;
use Psr\Container\ContainerInterface;

class LoginFormFactory
{
    public function __invoke(ContainerInterface $container): LoginForm
    {
        $form = new LoginForm($container->get(Options::class));
        $form->setInputFilter(new LoginFilter($container->get(Options::class)));
        return $form;
    }
}
