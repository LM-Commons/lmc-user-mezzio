<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Form\Exception\ExceptionInterface;
use Lmc\User\Mezzio\Exception\InvalidConfigurationException;
use Lmc\User\Mezzio\Options\Options;
use Lmc\User\Mezzio\Validator\NoRecordExists;
use Lmc\User\Repository\AdapterInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class RegisterFormFactory
{
    /**
     * @throws ExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): RegisterForm
    {
        $hydrator = $container->has('lmcuser_register_form_hydrator')
            ? $container->get('lmcuser_register_form_hydrator')
            : null;

        if (null === $hydrator) {
            throw new InvalidConfigurationException(
                'No register form hydrator available. Did you forget to add a use repository library?'
            );
        }
        /** @var Options $options */
        $options = $container->get(Options::class);
        $form    = new RegisterForm($options);

        /** @var AdapterInterface $mapper */
        $mapper = $container->get('lmcuser_user_mapper');

        $form->setHydrator($container->get('lmcuser_register_form_hydrator'));
        $form->setInputFilter(
            new RegisterFilter(
                new NoRecordExists([
                    'mapper' => $mapper,
                    'key'    => 'email',
                ]),
                new NoRecordExists([
                    'mapper' => $mapper,
                    'key'    => 'username',
                ]),
                $options,
            )
        );

        return $form;
    }
}
