<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Lmc\User\Mezzio\Options\Options;
use Psr\Container\ContainerInterface;

class ChangePasswordFormFactory
{
    public function __invoke(ContainerInterface $container): ChangePasswordForm
    {
        /** @var Options $options */
        $options = $container->get(Options::class);
        $form    = new ChangePasswordForm();

        $form->setInputFilter(new ChangePasswordFilter($options));
        return $form;
    }
}
