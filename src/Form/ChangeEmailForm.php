<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;

class ChangeEmailForm extends Form
{
    public function __construct()
    {
        parent::__construct('change-email-form');

        $this->add([
            'name' => 'identity',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name'    => 'credential',
            'type'    => Password::class,
            'options' => [
                'label' => 'Enter your password',
            ],
        ]);

        $this->add([
            'name'    => 'newIdentity',
            'type'    => Text::class,
            'options' => [
                'label' => 'New email',
            ],
        ]);

        $this->add([
            'name'    => 'newEmailVerify',
            'type'    => Text::class,
            'options' => [
                'label' => 'Verify new email',
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
