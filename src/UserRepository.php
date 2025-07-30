<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\User\Common\Mapper\UserMapperInterface;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\UserRepositoryInterface;

use function array_shift;
use function count;
use function in_array;
use function is_object;
use function password_verify;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private UserMapperInterface $mapper,
        private Options $options,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function authenticate(string $credential, ?string $password = null): ?UserInterface
    {
        $userObject = null;
        $fields     = $this->options->getAuthIdentityFields();
        while (! is_object($userObject) && count($fields) > 0) {
            $mode = array_shift($fields);
            switch ($mode) {
                case 'username':
                    $userObject = $this->mapper->findByUsername($credential);
                    break;
                case 'email':
                    $userObject = $this->mapper->findByEmail($credential);
                    break;
            }
        }
        if (null === $userObject) {
            return null;
        }

        if ($this->options->getEnableUserState()) {
            if (! in_array($userObject->getState(), $this->getOptions()->getAllowedLoginStates())) {
                return null;
            }
        }
        if (! password_verify($password, $userObject->getPassword())) {
            return null;
        }
        return $userObject;
    }
}
