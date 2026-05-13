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

class ChangeEmailFilter extends InputFilter
{
    public function __construct(
        private readonly ValidatorInterface $emailValidator,
        private readonly Options $options,
    ) {
        $this->add([
            'name'       => 'newEmail',
            'required'   => true,
            'filters'    => [
                new StringTrim(),
            ],
            'validators' => [
                new EmailAddress(),
                $this->emailValidator,
            ],
        ]);

        $this->add([
            'name'       => 'newEmailVerify',
            'required'   => true,
            'filters'    => [
                new StringTrim(),
            ],
            'validators' => [
                new EmailAddress(),
                new Identical([
                    'token'    => 'newEmail',
                    'messages' => [
                        Identical::NOT_SAME => 'Emails do not match',
                    ],
                ]),
            ],
        ]);

        $this->add([
            'name'       => 'credential',
            'required'   => true,
            'validators' => [
                new StringLength(['min' => $this->options->getMinPasswordLength()]),
            ],
            'filters'    => [new StringTrim()],
        ]);
    }
}
