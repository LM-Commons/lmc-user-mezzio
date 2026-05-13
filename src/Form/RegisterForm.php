<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\Captcha;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Text;
use Laminas\Form\Exception\ExceptionInterface;
use Laminas\Form\Form;
use Lmc\User\Mezzio\Options\Options;

class RegisterForm extends Form
{
    /**
     * @throws ExceptionInterface
     */
    public function __construct(
        private readonly Options $configOptions
    ) {
        parent::__construct('register-form');

        if ($this->configOptions->getEnableUsername()) {
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

        if ($this->configOptions->getEnableDisplayName()) {
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
            'type'       => Button::class,
            'options'    => [
                'label' => 'Register',
            ],
            'attributes' => [
                'type' => 'submit',
            ],
        ], [
            'priority' => -100,
        ]);

        if ($this->configOptions->getUseRegistrationFormCaptcha()) {
            $this->add([
                'name'    => 'captcha',
                'type'    => Captcha::class,
                'options' => [
                    'label'   => 'Please type the following text',
                    'captcha' => $this->configOptions->getUseRegistrationFormCaptcha(),
                ],
            ]);
        }
    }
}
