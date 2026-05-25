<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Service;

use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\Form\Form;
use Laminas\Hydrator\HydratorInterface;
use Lmc\User\Mezzio\Options\Options;
use Lmc\User\Repository\AdapterInterface;
use Lmc\User\Repository\UserInterface;
use Override;

final class UserService implements EventManagerAwareInterface, UserServiceInterface
{
    use EventManagerAwareTrait;

    public function __construct(
        private AdapterInterface $adapter,
        private Form $loginForm,
        private Form $registerForm,
        private readonly Form $changePasswordForm,
        private Options $options,
        private HydratorInterface $formHydrator,
        private readonly UserInterface $userEntity,
    ) {
    }

    #[Override]
    public function register(array $data): ?UserInterface
    {
        $user = clone $this->userEntity;
        $this->registerForm->setHydrator($this->formHydrator);
        $this->registerForm->bind($user);
        $this->registerForm->setData($data);
        if (! $this->registerForm->isValid()) {
            return null;
        }

        /** @var UserInterface $user */
        $user     = $this->registerForm->getData();
        $user->setRoles($this->options->getDefaultRoles());

        if ($this->options->getEnableUsername()) {
            $user->setUsername($data['username']);
        }
        if ($this->options->getEnableDisplayName()) {
            $user->setDisplayName($data['display_name']);
        }
        // If user state is enabled, set the default state value
        if ($this->options->getEnableUserState()) {
            $user->setState($this->options->getDefaultUserState());
        }
        $this->getEventManager()->trigger(
            __FUNCTION__,
            $this,
            ['user' => $user, 'form' => $this->registerForm]
        );
        $user = $this->adapter->insert($user);
        $this->getEventManager()->trigger(
            __FUNCTION__ . '.post',
            $this,
            ['user' => $user, 'form' => $this->registerForm]
        );
        return $user;
    }

    public function changePassword(UserInterface $user, string $oldPassword, string $newPassword): UserInterface|bool
    {
        // check old password is valid
        if (! $this->adapter->validateCredential($user, $oldPassword)) {
            return false;
        }
        $data = ['oldPassword' => $oldPassword, 'newPassword' => $newPassword];
        $this->getEventManager()->trigger(__FUNCTION__, $this, ['user' => $user, 'data' => $data]);
        $this->adapter->updateCredential($user, $newPassword);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, ['user' => $user, 'data' => $data]);
        return $user;
    }

    public function changeEmail(
        UserInterface $user,
        string $oldEmail,
        string $newEmail,
        string $credential
    ): UserInterface|bool {
        // check password is valid
        if (! $this->adapter->validateCredential($user, $credential)) {
            return false;
        }
        $user->setEmail($newEmail);
        $data = ['oldEmail' => $oldEmail, 'newEmail' => $newEmail];
        $this->getEventManager()->trigger(__FUNCTION__, $this, ['user' => $user, 'data' => $data]);
        $user = $this->adapter->update($user);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, ['user' => $user, 'data' => $data]);
        return $user;
    }
}
