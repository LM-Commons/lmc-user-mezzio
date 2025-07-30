<?php

declare(strict_types=1);

namespace LmcTest\User\Mezzio;

use Lmc\User\Mezzio\ConfigProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConfigProvider::class)]
class ConfigProviderTest extends TestCase
{
    public function testConfigProvider()
    {
        $configProvider = new ConfigProvider();
        $this->assertIsArray($configProvider());
        $this->assertArrayHasKey('dependencies', $configProvider());
        $this->assertArrayHasKey('templates', $configProvider());
    }
}
