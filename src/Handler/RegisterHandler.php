<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Authentication\AuthenticationService;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Form\FormInterface;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RegisterHandler implements RequestHandlerInterface
{

    public function __construct(
        private readonly TemplateRendererInterface $renderer,
        private readonly AuthenticationService     $authenticationService,
        private readonly Options                   $options,
        private readonly FormInterface             $form,
        private readonly UrlHelper                 $urlHelper,
    ) {
    }
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return match ($request->getMethod()) {
            'GET' => $this->handleGet($request),
            'POST' => $this->handlePost($request),
            default => new EmptyResponse(405),
        };
    }

    public function handleGet(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->authenticationService->hasIdentity()) {
            return new HtmlResponse(
                $this->renderer->render(
                    $this->options->getTemplate('register-not-allowed'),
                    [
                        'reason' => 'You are not allowed to register when logged in.',
                    ]
                ),
            );
        }
        if (! $this->options->getEnableRegistration()) {
            return new HtmlResponse(
                $this->renderer->render(
                    $this->options->getTemplate('register-not-allowed'),
                    [
                        'reason' => 'Registration is disabled.',
                    ]
                ),
            );
        }

        if ($this->options->getUseRedirectParameterIfPresent()) {
            $queryParams = $request->getQueryParams();
            $redirect    = $queryParams['redirect'] ?? false;
        } else {
            $redirect = false;
        }

        return new HtmlResponse(
            $this->renderer->render(
                $this->options->getTemplate('register'),
                [
                    'redirect' => $redirect,
                    'form'     => $this->form,
                ]
            )
        );

    }

    public function handlePost(ServerRequestInterface $request): ResponseInterface
    {
    }

}