<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio;

use Lmc\User\Mezzio\UserRepository\UserRepository;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                Authentication::class => AuthenticationFactory::class,
                UserRepository::class => UserRepositoryFactory::class,
            ],
        ];
    }
}
