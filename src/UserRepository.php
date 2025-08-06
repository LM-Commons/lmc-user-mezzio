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
    public function __construct(
        private AdapterInterface $adapter,
        private Options $options,
    ) {
    }

    public function authenticate(string $credential, ?string $password = null): ?UserInterface
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
            return null;
        }

        if ($this->options->getEnableUserState()) {
            if (! in_array($userObject->getState(), $this->options->getAllowedLoginStates())) {
                return null;
            }
        }
        if (! password_verify($password, $userObject->getPassword())) {
            return null;
        }
        return $userObject;
    }
}
