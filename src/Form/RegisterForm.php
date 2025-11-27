<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Lmc\User\Mezzio\Options\Options;

class RegisterForm extends Form
{
    public function __construct(Options $options)
    {
        parent::__construct('register-form');

        if ($options->getEnableUsername()) {
            $this->add([
                'name'       => 'username',
                'type'       => Text::class,
                'options'    => [
                    'label' => 'Username',
                ],
                'attributes' => [
                    'type' => 'text',
                ],
            ]);
        }

        $this->add([
            'name'       => 'email',
            'type'       => Text::class,
            'options'    => [
                'label' => 'Email',
            ],
            'attributes' => [
                'type' => 'text',
            ],
        ]);

        if ($options->getEnableDisplayName()) {
            $this->add([
                'name'       => 'display_name',
                'type'       => Text::class,
                'options'    => [
                    'label' => 'Display Name',
                ],
                'attributes' => [
                    'type' => 'text',
                ],
            ]);
        }


        $this->add([
            'name'       => 'password',
            'type'       => Password::class,
            'options'    => [
                'label' => 'Password',
            ],
            'attributes' => [
                'type' => 'password',
            ],
        ]);

        $this->add(
            [
                'name'       => 'passwordVerify',
                'type'       => Password::class,
                'options'    => [
                    'label' => 'Password Verify',
                ],
                'attributes' => [
                    'type' => 'password',
                ],
            ]
        );
        $this->add([
            'name'       => 'submit',
            'type'       => Submit::class,
            'options'    => [
                'label' => 'Register',
            ],
            'attributes' => [
                'type' => 'submit',
            ],
        ], [
            'priority' => -100,
        ]);
    }
}
