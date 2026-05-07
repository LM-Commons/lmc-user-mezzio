<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Filter\StringTrim;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Identical;
use Laminas\Validator\StringLength;
use Lmc\User\Mezzio\Options\Options;

class ChangePasswordFilter extends InputFilter
{
    public function __construct(
        private readonly Options $options,
    ) {
        $this->add([
            'name'       => 'credential',
            'required'   => true,
            'filters'    => [
                new StringTrim(),
            ],
            'validators' => [
                new StringLength([
                    'min' => $this->options->getMinPasswordLength(),
                ]),
            ],
        ]);

        $this->add([
            'name'       => 'newCredential',
            'required'   => true,
            'filters'    => [
                new StringTrim(),
            ],
            'validators' => [
                new StringLength([
                    'min' => $this->options->getMinPasswordLength(),
                ]),
            ],
        ]);

        $this->add([
            'name'       => 'newCredentialVerify',
            'required'   => true,
            'filters'    => [
                new StringTrim(),
            ],
            'validators' => [
                new StringLength([
                    'min' => $this->options->getMinPasswordLength(),
                ]),
                new Identical([
                    'token' => 'newCredential',
                ]),
            ],
        ]);
    }
}
