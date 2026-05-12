<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;
use Laminas\Form\Form;
use Lmc\User\Mezzio\Options\Options;

class ChangePasswordForm extends Form
{
    public function __construct(
        private readonly Options $configOptions
    ) {
        parent::__construct('change-password-form');

        $this->add([
            'name' => 'identity',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name'    => 'credential',
            'type'    => Password::class,
            'options' => [
                'label' => 'Current password',
            ],
        ]);

        $this->add([
            'name'    => 'newCredential',
            'type'    => Password::class,
            'options' => [
                'label' => 'New password',
            ],
        ]);
        $this->add([
            'name'    => 'newCredentialVerify',
            'type'    => Password::class,
            'options' => [
                'label' => 'Verify New password',
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => Button::class,
            'options'    => [
                'label' => 'Change password',
            ],
            'attributes' => [
                'type' => 'submit',
            ],
        ]);
    }
}
