<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\Authentication\UnauthorizedResponseInterface;
use Lmc\User\Mezzio\Options\Options;
use Lmc\User\Repository\AdapterInterface;
use Mezzio\Helper\UrlHelperInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class UnauthorizedResponse implements UnauthorizedResponseInterface
{
    public function __construct(
        private UrlHelperInterface       $urlHelper,
        private ResponseFactoryInterface $responseFactory,
        private Options                  $options
    ) {
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
}
