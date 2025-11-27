<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Lmc\User\Mezzio\Options\Options;

use function ucfirst;

class LoginForm extends Form
{
    public function __construct(Options $options)
    {
        parent::__construct('login-form');
        $this->add([
            'name'    => 'identity',
            'type'    => Text::class,
            'options' => [
                'label' => 'Username',
            ],
        ]);

        $emailElement = $this->get('identity');
        $label        = $emailElement->getLabel('label');
        // @TODO: make translation-friendly
        foreach ($options->getAuthIdentityFields() as $mode) {
            $label = (! empty($label) ? $label . ' or ' : '') . ucfirst($mode);
        }
        $emailElement->setLabel($label);

        $this->add([
            'name'       => 'credential',
            'type'       => Password::class,
            'options'    => [
                'label' => 'Password',
            ],
            'attributes' => [],
        ]);
        if ($options->getUseLoginFormCsrf()) {
            $this->add([
                'type'    => Csrf::class,
                'name'    => 'security',
                'options' => [
                    'csrf_options' => [
                        'timeout' => $options->getLoginFormTimeout(),
                    ],
                ],
            ]);
        }
        $this->add([
            'name'       => 'submit',
            'type'       => Button::class,
            'options'    => [
                'label' => 'Sign In',
            ],
            'attributes' => [
                'type' => 'submit',
            ],
        ], [
            'priority' => -100,
        ]);
    }
}
