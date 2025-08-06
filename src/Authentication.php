<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\Authentication\AuthenticationInterface;
use Lmc\Authentication\UserInterface;
use Lmc\User\Repository\AdapterInterface;
use Mezzio\Session\SessionInterface;
use Mezzio\Session\SessionMiddleware;
use Psr\Http\Message\ServerRequestInterface;

use function strtoupper;

final readonly class Authentication implements AuthenticationInterface
{
    public function __construct(
        private AdapterInterface $userAdapter,
        private UserRepository $userRepository,
    ) {
    }

    public function authenticate(ServerRequestInterface $request): ?UserInterface
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        if (! $session instanceof SessionInterface) {
            throw Exception\MissingSessionContainerException::create();
        }

        if ($session->has(UserInterface::class)) {
            return $this->createUserFromSession($session);
        }

        if ('POST' !== strtoupper($request->getMethod())) {
            return null;
        }

        $params     = $request->getParsedBody();
        $identity   = $params['identity'] ?? null;
        $credential = $params['credential'] ?? null;
        if (! $identity || ! $credential) {
            return null;
        }

        $user = $this->userRepository->authenticate($identity, $credential);
        if (null !== $user) {
            $session->set(UserInterface::class, $user->getIdentity());
            $session->regenerate();
        }
        return $user;
    }

    public function reset(ServerRequestInterface $request): void
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        if ($session instanceof SessionInterface) {
            $session->clear();
            $session->regenerate();
        }
    }

    private function createUserFromSession(SessionInterface $session): ?UserInterface
    {
        /** @var int $id */
        $id   = $session->get(UserInterface::class);
        $user = $this->userAdapter->findById($id);
        if (! $user instanceof UserInterface) {
            return null;
        }
        return $user;
    }
}
