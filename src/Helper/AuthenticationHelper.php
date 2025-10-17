<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Helper;

use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\AuthenticationServiceInterface;

class AuthenticationHelper
{
    public function __construct(
        protected AuthenticationServiceInterface $authenticationService,
        protected AdapterInterface $adapter,
    ) {
    }

    public function hasIdentity(): bool
    {
        return $this->authenticationService->hasIdentity();
    }

    public function getIdentity(): mixed
    {
        return $this->authenticationService->getIdentity();
    }

    public function getAuthAdapter(): AdapterInterface
    {
        return $this->adapter;
    }
}
