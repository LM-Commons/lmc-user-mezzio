<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Model\ViewModel;
use Lmc\User\Mezzio\Form\LoginForm;

use function array_key_exists;

class LmcUserLoginWidget extends AbstractHelper
{
    public function __construct(
        protected LoginForm $loginForm,
        protected string $viewTemplate,
    ) {
    }

    public function __invoke(array $options = []): string|ViewModel
    {
        $render   = array_key_exists('render', $options) && $options['render'];
        $redirect = array_key_exists('redirect', $options) && $options['redirect'];

        $viewModel = new ViewModel([
            'loginForm' => $this->loginForm,
            'redirect'  => $redirect,
        ]);
        $viewModel->setTemplate($this->viewTemplate);
        if ($render) {
            return $this->getView()->render($viewModel);
        } else {
            return $viewModel;
        }
    }
}
