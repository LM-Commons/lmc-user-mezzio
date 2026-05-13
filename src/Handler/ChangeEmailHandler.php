<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Handler;

use Laminas\Authentication\AuthenticationService;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Form\Exception\ExceptionInterface;
use Laminas\Form\FormInterface;
use Lmc\User\Mezzio\Options\Options;
use Lmc\User\Mezzio\Service\UserServiceInterface;
use Lmc\User\Repository\UserInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function assert;

class ChangeEmailHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly TemplateRendererInterface $renderer,
        private readonly AuthenticationService $authenticationService,
        private readonly Options $options,
        private readonly FormInterface $form,
        private readonly UserServiceInterface $userService,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->authenticationService->hasIdentity()) {
            return new HtmlResponse(
                $this->renderer->render(
                    $this->options->getTemplate('change-email-not-allowed'),
                    [
                        'reason' => 'You must be logged in to change your email.',
                    ]
                ),
            );
        }

        return match ($request->getMethod()) {
            'POST' => $this->handlePost($request),
            'GET'  => $this->handleGet($request),
        };
    }

    public function handleGet(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse(
            $this->renderer->render(
                $this->options->getTemplate('change-email'),
                [
                    'form' => $this->form,
                ]
            )
        );
    }

    /**
     * @throws ExceptionInterface
     */
    public function handlePost(ServerRequestInterface $request): ResponseInterface
    {
        $post = $request->getParsedBody();
        $user = $this->authenticationService->getIdentity();
        assert($user instanceof UserInterface);
        $this->form->setData($post);
        if ($this->form->isValid()) {
            $data = $this->form->getData();
            $user = $this->userService->changeEmail($user, $data['credential'], $data['newEmail']);

            if ($user instanceof UserInterface) {
                return new HtmlResponse(
                    $this->renderer->render(
                        $this->options->getTemplate('change-email'),
                        [
                            'form'     => $this->form,
                            'messages' => [
                                [
                                    'success' => 'Your email has been changed successfully.',
                                ],
                            ],
                        ]
                    )
                );
            } else {
                return new HtmlResponse(
                    $this->renderer->render(
                        $this->options->getTemplate('change-email'),
                        [
                            'form'     => $this->form,
                            'messages' => [
                                [
                                    'danger' => 'Invalid password. Try again.',
                                ],
                            ],
                        ]
                    )
                );
            }
        }
        return new HtmlResponse(
            $this->renderer->render(
                $this->options->getTemplate('change-email'),
                [
                    'form' => $this->form,
                ]
            )
        );
    }
}
