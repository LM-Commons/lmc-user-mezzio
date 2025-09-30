<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Diactoros\Response\RedirectResponse;
use Lmc\User\Mezzio\Authentication;
use Lmc\User\Mezzio\Options\Options;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutHandler implements RequestHandlerInterface
{
    public function __construct(
        private Authentication $adapter,
        private Options $options,
        private UrlHelper $urlHelper,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->adapter->reset($request);
        return new RedirectResponse(
            $this->urlHelper->generate(
                $this->options->getLogoutRedirectRoute(),
            )
        );
    }
}
