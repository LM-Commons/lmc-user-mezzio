<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\UserRepository;

use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function authenticate(string $credential, ?string $password = null): ?UserInterface
    {
        return null;
    }
}
