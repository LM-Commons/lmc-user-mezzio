<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Form\FormInterface;
use Lmc\Authentication\UserInterface;
use Lmc\User\Mezzio\Authentication;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginHandler implements RequestHandlerInterface
{
    public function __construct(
        private TemplateRendererInterface $renderer,
        private Authentication $adapter,
        private Options $options,
        private FormInterface $loginForm,
        private UrlHelper $urlHelper,
    ) {
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
        if ($this->options->getLoginRedirectRoute()) {
            $queryParams = $request->getQueryParams();
            $redirect    = $queryParams['redirect'] ?? false;
        } else {
            $redirect = false;
        }
        return new HtmlResponse($this->renderer->render(
            'lmcuser::login',
            [
                'loginForm'          => $this->loginForm,
                'redirect'           => $redirect,
                'enableRegistration' => $this->options->getEnableRegistration(),
            ]
        ));
    }

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
                'lmcuser::login',
                [
                    'loginForm'          => $this->loginForm,
                    'redirect'           => $redirect,
                    'enableRegistration' => $this->options->getEnableRegistration(),
                ]
            ));
        }
        $this->adapter->reset($request);
        $result = $this->adapter->prepareForAuthentication($request);
        if (! $result instanceof UserInterface) {
            return new HtmlResponse($this->renderer->render(
                $this->options->getTemplate('login'),
                [
                    'loginForm'          => $this->loginForm,
                    'redirect'           => $redirect,
                    'enableRegistration' => $this->options->getEnableRegistration(),
                    'error'              => $result,
                ]
            ));
        }

        return new RedirectResponse(
            $this->urlHelper->generate($this->options->getLoginRedirectRoute())
        );
    }
}
