<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Options;

use Laminas\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    //phpcs:disable
    protected $__strictMode__ = false;
    //phpcs:enable

    protected bool $useRedirectParameterIfPresent = true;

}
