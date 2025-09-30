<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\Authentication\UserInterface;
use Lmc\User\Mezzio\Options\Options;
use Lmc\User\Repository\AdapterInterface;

use function array_shift;
use function count;
use function in_array;
use function is_object;
use function password_verify;

readonly class UserRepository
{
    public const USER_NOT_FOUND      = 0;
    public const USER_NOT_ALLOWED    = 1;
    public const INVALID_CREDENTIALS = 2;

    public function __construct(
        private AdapterInterface $adapter,
        private Options $options,
    ) {
    }

    public function authenticate(string $credential, ?string $password = null): UserInterface|int
    {
        $userObject = null;
        $fields     = $this->options->getAuthIdentityFields();
        while (! is_object($userObject) && count($fields) > 0) {
            $mode = array_shift($fields);
            switch ($mode) {
                case 'username':
                    $userObject = $this->adapter->findByUsername($credential);
                    break;
                case 'email':
                    $userObject = $this->adapter->findByEmail($credential);
                    break;
            }
        }
        if (null === $userObject) {
            return self::USER_NOT_FOUND;
        }

        if ($this->options->getEnableUserState()) {
            if (! in_array($userObject->getState(), $this->options->getAllowedLoginStates())) {
                return self::USER_NOT_ALLOWED;
            }
        }
        if (! password_verify($password, $userObject->getPassword())) {
            return self::INVALID_CREDENTIALS;
        }
        return $userObject;
    }
}
