<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Form;

use Laminas\Filter\StringTrim;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\StringLength;
use Lmc\User\Mezzio\Options\Options;

class LoginFilter extends InputFilter
{
    public function __construct(
        private Options $options
    ) {
        $identityParams = [
            'name'       => 'identity',
            'required'   => true,
            'validators' => [],
            'filters'    => [new StringTrim()],
        ];

        $identityField = $this->options->getAuthIdentityFields();
        if ($identityField === ['email']) {
            $validators                     = [
                new EmailAddress(),
            ];
            $identityParams['validators'][] = $validators;
        }
        $this->add($identityParams);
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
