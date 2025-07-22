<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\UserInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class Authentication implements AuthenticationInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function authenticate(ServerRequestInterface $request): ?UserInterface
    {
        return null;
    }

    public function unauthorizedResponse(ServerRequestInterface $request): ResponseInterface
    {
        return $this->responseFactory->createResponse(401);
    }
}
