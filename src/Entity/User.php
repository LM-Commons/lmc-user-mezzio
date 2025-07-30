<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Entity;

use Lmc\User\Common\Entity\AbstractUser;
use Mezzio\Authentication\UserInterface;

class User extends AbstractUser implements UserInterface
{
    /**
     * @inheritDoc
     */
    public function getIdentity(): string
    {
        return (string) $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getDetail(string $name, $default = null)
    {
        // TODO: Implement getDetail() method.
    }

    /**
     * @inheritDoc
     */
    public function getDetails(): array
    {
        return [
            'user' => $this,
        ];
    }
}
