<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Filter\StringTrim;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Laminas\Validator\StringLength;
use Laminas\Validator\ValidatorInterface;
use Lmc\User\Mezzio\Options\Options;

class RegisterFilter extends InputFilter
{
    public function __construct(
        private readonly ValidatorInterface $emailValidator,
        private readonly ValidatorInterface $usernameValidator,
        private readonly Options $options,
    ) {
        if ($this->options->getEnableUsername()) {
            $this->add([
                'name'       => 'username',
                'required'   => true,
                'filters'    => [
                    new StringTrim(),
                ],
                'validators' => [
                    new StringLength([
                        'min' => 3,
                        'max' => 255,
                    ]),
                    $this->usernameValidator,
                ],
            ]);
        }

        $this->add([
            'name'       => 'email',
            'required'   => true,
            'filters'    => [
                new StringTrim(),
            ],
            'validators' => [
                new EmailAddress(),
                $this->emailValidator,
            ],
        ]);

        if ($this->options->getEnableDisplayName()) {
            $this->add([
                'name'       => 'display_name',
                'required'   => true,
                'filters'    => [
                    new StringTrim(),
                ],
                'validators' => [
                    new StringLength([
                        'min' => 3,
                        'max' => 255,
                    ]),
                ],
            ]);
        }

        $this->add([
            'name'       => 'password',
            'required'   => true,
            'filters'    => [
                new StringTrim(),
            ],
            'validators' => [
                new StringLength([
                    'min' => $this->options->getMinPasswordLength(),
                    'max' => 255,
                ]),
            ],
        ]);

        $this->add([
            'name'       => 'passwordVerify',
            'required'   => true,
            'filters'    => [
                new StringTrim(),
            ],
            'validators' => [
                new StringLength([
                    'min' => $this->options->getMinPasswordLength(),
                    'max' => 255,
                ]),
                new Identical([
                    'token' => 'password',
                ]),
            ],
        ]);
    }
}
