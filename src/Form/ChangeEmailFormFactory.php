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

class ChangeEmailFormFactory
{
    /**
     * @throws ExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ChangeEmailForm
    {
        /** @var AdapterInterface|null $mapper */
        $mapper = $container->has(AdapterInterface::class)
            ? $container->get(AdapterInterface::class)
            : null;

        if (null === $mapper) {
            throw new InvalidConfigurationException(
                'No User Repository adapter available. Did you forget to add a use repository library?'
            );
        }

        /** @var Options $options */
        $options = $container->get(Options::class);
        $form    = new ChangeEmailForm();

        $form->setInputFilter(
            new ChangeEmailFilter(
                new NoRecordExists([
                    'mapper' => $mapper,
                    'key'    => 'email',
                ]),
            )
        );

        return $form;
    }
}
