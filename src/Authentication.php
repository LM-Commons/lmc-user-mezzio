<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\User\Common\Mapper\User;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\UserRepositoryInterface;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Session\SessionInterface;
use Mezzio\Session\SessionMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function strtoupper;

class Authentication implements AuthenticationInterface
{
    /** @var callable */
    private $userFactory;

    public function __construct(
        private UrlHelperInterface $urlHelper,
        private ResponseFactoryInterface $responseFactory,
        private Options $options,
        private readonly User $mapper,
        callable $userFactory,
        private UserRepositoryInterface $userRepository
    ) {
        $this->userFactory = static fn(string $identity, array $roles = [], array $details = []): UserInterface
        => $userFactory($identity, $roles, $details);
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

    public function unauthorizedResponse(ServerRequestInterface $request): ResponseInterface
    {
        $redirectRoute = $this->options->getUnauthorizedRedirectRoute();
        return $this->responseFactory
            ->createResponse(302)
            ->withHeader(
                'Location',
                $this->urlHelper->generate($redirectRoute)
            );
    }

    public function logout(ServerRequestInterface $request): void
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
        $user = $this->mapper->findById((int) $id);
        if (! $user instanceof UserInterface) {
            return null;
        }
        return $user;
    }
}
