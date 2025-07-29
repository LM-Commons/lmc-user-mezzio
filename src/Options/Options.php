<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Options;

use Laminas\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    //phpcs:disable
    protected $__strictMode__ = false;
    //phpcs:enable

    protected bool $useRedirectParameterIfPresent = true;
    protected string $loginRedirectRoute          = 'lmcuser';
    protected string $logoutRedirectRoute         = 'lmcuser/login';
    protected int $loginFormTimeout               = 300;
    protected int $userFormTimeout                = 300;
    protected bool $loginAfterRegistration        = true;
    protected bool $enableUserState               = false;
    protected int $defaultUserState               = 1;
    protected array $allowedLoginStates           = [null, 1];
    protected array $authAdapters                 = [100 => 'LmcUser\Authentication\Adapter\Db'];
    protected array $authIdentityFields           = ['email'];
    protected string $userEntityClass             = 'LmcUser\Entity\User';
    protected string $userLoginWidgetViewTemplate = 'lmc-user/user/login.phtml';
    protected bool $enableRegistration            = true;
    protected bool $enableUsername                = false;
    protected bool $enableDisplayName             = false;
    protected bool $useRegistrationFormCaptcha    = false;
    protected bool $useLoginFormCaptcha           = false;
    protected bool $useLoginFormCsrf              = true;
    protected int $passwordCost                   = 14;
    protected array $formCaptchaOptions           = [
        'class'   => 'figlet',
        'options' => [
            'wordLen'    => 5,
            'expiration' => 300,
            'timeout'    => 300,
        ],
    ];

    public function setLoginRedirectRoute(string $loginRedirectRoute): self
    {
        $this->loginRedirectRoute = $loginRedirectRoute;
        return $this;
    }

    /**
     * get login redirect route
     */
    public function getLoginRedirectRoute(): string
    {
        return $this->loginRedirectRoute;
    }

    public function setLogoutRedirectRoute(string $logoutRedirectRoute): self
    {
        $this->logoutRedirectRoute = $logoutRedirectRoute;
        return $this;
    }

    /**
     * get logout redirect route
     */
    public function getLogoutRedirectRoute(): string
    {
        return $this->logoutRedirectRoute;
    }

    /**
     * set use redirect param if present
     */
    public function setUseRedirectParameterIfPresent(bool $useRedirectParameterIfPresent): self
    {
        $this->useRedirectParameterIfPresent = $useRedirectParameterIfPresent;
        return $this;
    }

    /**
     * get use redirect param if present
     */
    public function getUseRedirectParameterIfPresent(): bool
    {
        return $this->useRedirectParameterIfPresent;
    }

    /**
     * set the view template for the user login widget
     */
    public function setUserLoginWidgetViewTemplate(string $userLoginWidgetViewTemplate): self
    {
        $this->userLoginWidgetViewTemplate = $userLoginWidgetViewTemplate;
        return $this;
    }

    /**
     * get the view template for the user login widget
     */
    public function getUserLoginWidgetViewTemplate(): string
    {
        return $this->userLoginWidgetViewTemplate;
    }

    public function setEnableRegistration(bool $enableRegistration): self
    {
        $this->enableRegistration = $enableRegistration;
        return $this;
    }

    public function getEnableRegistration(): bool
    {
        return $this->enableRegistration;
    }

    public function setLoginFormTimeout(int $loginFormTimeout): self
    {
        $this->loginFormTimeout = $loginFormTimeout;
        return $this;
    }

    public function getLoginFormTimeout(): int
    {
        return $this->loginFormTimeout;
    }

    public function setUserFormTimeout(int $userFormTimeout): self
    {
        $this->userFormTimeout = $userFormTimeout;
        return $this;
    }

    public function getUserFormTimeout(): int
    {
        return $this->userFormTimeout;
    }

    public function setLoginAfterRegistration(bool $loginAfterRegistration): self
    {
        $this->loginAfterRegistration = $loginAfterRegistration;
        return $this;
    }

    public function getLoginAfterRegistration(): bool
    {
        return $this->loginAfterRegistration;
    }

    public function getEnableUserState(): bool
    {
        return $this->enableUserState;
    }

    public function setEnableUserState(bool $flag): self
    {
        $this->enableUserState = $flag;
        return $this;
    }

    public function getDefaultUserState(): int
    {
        return $this->defaultUserState;
    }

    public function setDefaultUserState(int $state): self
    {
        $this->defaultUserState = $state;
        return $this;
    }

    public function getAllowedLoginStates(): array
    {
        return $this->allowedLoginStates;
    }

    public function setAllowedLoginStates(array $states): self
    {
        $this->allowedLoginStates = $states;
        return $this;
    }

    public function setAuthAdapters(array $authAdapters): self
    {
        $this->authAdapters = $authAdapters;
        return $this;
    }

    public function getAuthAdapters(): array
    {
        return $this->authAdapters;
    }

    public function setAuthIdentityFields(array $authIdentityFields): self
    {
        $this->authIdentityFields = $authIdentityFields;
        return $this;
    }

    public function getAuthIdentityFields(): array
    {
        return $this->authIdentityFields;
    }

    public function setEnableUsername(bool $flag): self
    {
        $this->enableUsername = (bool) $flag;
        return $this;
    }

    public function getEnableUsername(): bool
    {
        return $this->enableUsername;
    }

    public function setEnableDisplayName(bool $flag): self
    {
        $this->enableDisplayName = (bool) $flag;
        return $this;
    }

    public function getEnableDisplayName(): bool
    {
        return $this->enableDisplayName;
    }

    public function setUseRegistrationFormCaptcha(bool $useRegistrationFormCaptcha): self
    {
        $this->useRegistrationFormCaptcha = $useRegistrationFormCaptcha;
        return $this;
    }

    public function getUseRegistrationFormCaptcha(): bool
    {
        return $this->useRegistrationFormCaptcha;
    }

    public function setUseLoginFormCaptcha(bool $useLoginFormCaptcha): self
    {
        $this->useLoginFormCaptcha = $useLoginFormCaptcha;
        return $this;
    }

    public function getUseLoginFormCaptcha(): bool
    {
        return $this->useLoginFormCaptcha;
    }

    public function setUseLoginFormCsrf(bool $useLoginFormCsrf): self
    {
        $this->useLoginFormCsrf = $useLoginFormCsrf;
        return $this;
    }

    public function getUseLoginFormCsrf(): bool
    {
        return $this->useLoginFormCsrf;
    }

    public function setUserEntityClass(string $userEntityClass): self
    {
        $this->userEntityClass = $userEntityClass;
        return $this;
    }

    public function getUserEntityClass(): string
    {
        return $this->userEntityClass;
    }

    public function setPasswordCost(int $passwordCost): self
    {
        $this->passwordCost = $passwordCost;
        return $this;
    }

    public function getPasswordCost(): int
    {
        return $this->passwordCost;
    }

    public function setFormCaptchaOptions(array $formCaptchaOptions): self
    {
        $this->formCaptchaOptions = $formCaptchaOptions;
        return $this;
    }

    public function getFormCaptchaOptions(): array
    {
        return $this->formCaptchaOptions;
    }
}
