<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Entity;

use Lmc\User\Common\Entity\AbstractUser;
use Mezzio\Authentication\UserInterface;

use function get_object_vars;

class User extends AbstractUser implements UserInterface
{
    /**
     * @inheritDoc
     */
    public function getIdentity(): string
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): iterable
    {
        return [];
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
        return get_object_vars($this);
    }
}
