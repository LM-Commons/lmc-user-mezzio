<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Authentication\AuthenticationService;
use Laminas\Diactoros\Response\RedirectResponse;
use Lmc\User\Authentication\Adapter\AdapterChain;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class LogoutHandler implements RequestHandlerInterface
{
    /** @var callable $redirectCallback */
    protected $redirectCallback;

    public function __construct(
        private AuthenticationService $authenticationService,
        private Options $options,
        private UrlHelper $urlHelper,
        callable $redirectCallback
    ) {
        $this->redirectCallback = $redirectCallback;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $adapter = $this->authenticationService->getAdapter();
        /** @var AdapterChain $adapter */
        $adapter->resetAdapters();
        $adapter->logoutAdapters();
        $this->authenticationService->clearIdentity();

        $redirectCallback = $this->redirectCallback;
        return $redirectCallback();
/*
        return new RedirectResponse(
            $this->urlHelper->generate(
                $this->options->getLogoutRedirectRoute(),
            )
        );
*/
    }
}
