<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Service;

use Lmc\User\Repository\UserInterface;

interface UserServiceInterface
{
    public function register(array $data): ?UserInterface;

    public function changePassword(UserInterface $user, string $oldPassword, string $newPassword): UserInterface|bool;

    public function changeEmail(
        UserInterface $user,
        string $oldEmail,
        string $newEmail,
        string $credential,
    ): UserInterface|bool;
}
