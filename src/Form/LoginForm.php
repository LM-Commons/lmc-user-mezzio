<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Lmc\User\Mezzio\Options\Options;

class LoginForm extends Form
{
    /**
     * @param string|null $name
     */
    //phpcs:disable
    public function __construct($name = null, Options $options)
    {
        parent::__construct('login');
        $this->add([
            'name'    => 'identity',
            'type'    => Text::class,
            'options' => [
                'label' => 'Username',
            ],
        ]);
        $this->add([
            'name'       => 'credential',
            'type'       => Password::class,
            'options'    => [
                'label' => 'Password',
            ],
            'attributes' => [],
        ]);
        $this->add([
            'name'       => 'submit',
            'type'       => Button::class,
            'options'    => [
                'label' => 'Login',
            ],
            'attributes' => [
                'type' => 'submit',
            ],
        ], [
            'priority' => -100,
        ]);
    }
}
