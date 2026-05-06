<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Authentication\AuthenticationService;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Form\Exception\ExceptionInterface;
use Laminas\Form\FormInterface;
use Lmc\User\Authentication\Adapter\AdapterChain;
use Lmc\User\Mezzio\Options\Options;
//use Lmc\Authentication\UserInterface;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginHandler implements RequestHandlerInterface
{
    /** @var callable $redirectCallback */
    protected $redirectCallback;

    public function __construct(
        private readonly TemplateRendererInterface $renderer,
        private readonly AuthenticationService $authenticationService,
        private readonly Options $options,
        private readonly FormInterface $loginForm,
        private readonly UrlHelper $urlHelper,
        callable $redirectCallback,
    ) {
        $this->redirectCallback = $redirectCallback;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return match ($request->getMethod()) {
            'GET' => $this->handleGet($request),
            'POST' => $this->handlePost($request),
            default => new EmptyResponse(405),
        };
    }

    private function handleGet(ServerRequestInterface $request): ResponseInterface
    {
        // logout first
        /** @var AdapterChain $adapter */
        $adapter = $this->authenticationService->getAdapter();
        $adapter->resetAdapters($request);
        $adapter->logoutAdapters($request);
        $this->authenticationService->clearIdentity();

        if ($this->options->getLoginRedirectRoute()) {
            $queryParams = $request->getQueryParams();
            $redirect    = $queryParams['redirect'] ?? false;
        } else {
            $redirect = false;
        }
        return new HtmlResponse($this->renderer->render(
            $this->options->getTemplate('login'),
            [
                'loginForm'          => $this->loginForm,
                'redirect'           => $redirect,
                'enableRegistration' => $this->options->getEnableRegistration(),
            ]
        ));
    }

    /**
     * @throws ExceptionInterface
     * @throws \Laminas\Authentication\Exception\ExceptionInterface
     */
    private function handlePost(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->options->getLoginRedirectRoute()) {
            $queryParams = $request->getQueryParams();
            $redirect    = $queryParams['redirect'] ?? false;
        } else {
            $redirect = false;
        }
        $this->loginForm->setData($request->getParsedBody());
        if (! $this->loginForm->isValid()) {
            return new HtmlResponse($this->renderer->render(
                $this->options->getTemplate('login'),
                [
                    'loginForm'          => $this->loginForm,
                    'redirect'           => $redirect,
                    'enableRegistration' => $this->options->getEnableRegistration(),
                ]
            ));
        }
        /** @var AdapterChain $adapter */
        $adapter = $this->authenticationService->getAdapter();
        $adapter->resetAdapters($request);
        $this->authenticationService->clearIdentity();
        $result = $adapter->prepareForAuthentication($request);

        // Return early if an adapter returned a response
        if ($result instanceof ResponseInterface) {
            return $result;
        }
        $authResult = $this->authenticationService->authenticate($adapter);

        if (! $authResult->isValid()) {
            return new HtmlResponse($this->renderer->render(
                $this->options->getTemplate('login'),
                [
                    'loginForm'          => $this->loginForm,
                    'redirect'           => $redirect,
                    'enableRegistration' => $this->options->getEnableRegistration(),
                    'messages'           => $authResult->getMessages(),
                ]
            ));
        }

        $redirectCallback = $this->redirectCallback;
        return $redirectCallback($request);
    }
}
