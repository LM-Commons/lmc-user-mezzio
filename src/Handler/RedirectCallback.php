<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Uri\Uri;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Exception\RuntimeException;
use Mezzio\Router\RouteResult;
use Mezzio\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;

class RedirectCallback
{
    public function __construct(
        private readonly Options $options,
        private readonly RouterInterface $router
    ) {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        assert($routeResult instanceof RouteResult);
        $routeMatched = $routeResult->getMatchedRouteName();
        $redirect     = $this->getRedirect($routeMatched, $this->getRedirectRouteFromRequest($request));
        return new RedirectResponse($redirect);
    }

    private function getRedirect(string $currentRoute, bool|string $redirect = false): string
    {
        $useRedirect  = $this->options->getUseRedirectParameterIfPresent();
        $routeMatched = $redirect && $this->routeMatched($currentRoute);
        $routeExists  = $redirect && (! $routeMatched && $this->routeExists($currentRoute));

        if (! $useRedirect || ! ($routeMatched || $routeExists)) {
            $redirect = false;
        }

        switch ($currentRoute) {
            case 'lmcuser.login':
            case 'lmcuser.register':
                if ($redirect && $routeMatched) {
                    return $redirect;
                } else {
                    $route = $redirect ?: $this->options->getLoginRedirectRoute();
                    return $this->router->generateUri($route);
                }
                break;
            case 'lmcuser.logout':
                $route = $redirect ?: $this->options->getLogoutRedirectRoute();
                return $this->router->generateUri($route);
                break;
            default:
                return $this->router->generateUri('lmcuser');
        }
    }

    private function routeMatched(string $route): bool
    {
        try {
            $this->router->generateUri($route);
        } catch (RuntimeException $e) {
            return false;
        }
        return true;
    }

    private function routeExists(string $route): bool
    {
        try {
            $this->router->generateUri($route);
        } catch (RuntimeException $e) {
            return false;
        }
        return true;
    }

    private function getRedirectRouteFromRequest(ServerRequestInterface $request): string|bool
    {
        $redirect = $request->getQueryParams()['redirect'] ?? null;
        if (null === $redirect) {
            $redirect = $request->getParsedBody()['redirect'] ?? null;
        }

        if ($redirect) {
            if ($this->routeExists($redirect)) {
                return $redirect;
            } else {
                // it may be a uri
                $uri = $this->isUri($redirect);
                if ($uri) {
                    return $uri;
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    private function isUri(string $route): bool|Uri
    {
        $uri = new Uri($route);
        if ($uri->isValid()) {
            return $uri;
        }
        return false;
    }
}
