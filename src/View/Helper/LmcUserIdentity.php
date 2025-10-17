<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\View\Helper;

use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\View\Helper\AbstractHelper;
use Lmc\User\Repository\UserInterface;

class LmcUserIdentity extends AbstractHelper
{
    public function __construct(
        protected AuthenticationServiceInterface $authenticationService
    ) {
    }

    public function __invoke(): UserInterface|bool
    {
        if ($this->authenticationService->hasIdentity()) {
            return $this->authenticationService->getIdentity();
        } else {
            return false;
        }
    }
}
