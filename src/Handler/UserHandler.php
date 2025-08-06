<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Lmc\Authentication\UserInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class UserHandler implements RequestHandlerInterface
{
    public function __construct(
        private TemplateRendererInterface $renderer,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute(UserInterface::class);
        return new HtmlResponse($this->renderer->render(
            'lmcuser::user',
            [
                'user' => $user,
            ]
        ));
    }
}
