<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\View\Helper;

use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\View\Helper\AbstractHelper;
use Lmc\User\Mezzio\Exception\DomainException;
use Lmc\User\Repository\UserInterface;

use function strpos;
use function substr;

class LmcUserDisplayName extends AbstractHelper
{
    public function __construct(
        protected AuthenticationServiceInterface $authService,
    ) {
    }

    public function __invoke(?UserInterface $user = null): string|bool
    {
        if (null === $user) {
            if ($user = $this->authService->hasIdentity()) {
                $user = $this->authService->getIdentity();
                if (! $user instanceof UserInterface) {
                    throw new DomainException(
                        '$user is not an instance of Lmc\User\Repository\UserInterface'
                    );
                }
            } else {
                return false;
            }
        }
        $displayName = $user->getDisplayName();
        if (null === $displayName) {
            $displayName = $user->getUsername();
        }
        if (null === $displayName) {
            $displayName = $user->getEmail();
            $displayName = substr($displayName, 0, strpos($displayName, '@'));
        }

        return $displayName;
    }
}
