<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Tests\Driver\Factory;

use Alphpaca\SyliusBehat\Driver\Factory\PlaywrightDriverFactory;
use PHPUnit\Framework\TestCase;
use Playwright\Mink\Driver\PlaywrightDriver;

final class PlaywrightDriverFactoryTest extends TestCase
{
    public function testBuildsPlaywrightDriverDefinition(): void
    {
        $factory = new PlaywrightDriverFactory();

        $this->assertSame('playwright', $factory->getDriverName());
        $this->assertTrue($factory->supportsJavascript());

        $definition = $factory->buildDriver([
            'browser_type' => 'firefox',
            'headless' => false,
            'launch_options' => ['slowMo' => 100],
            'context_options' => [],
        ]);

        $this->assertSame(PlaywrightDriver::class, $definition->getClass());
        $this->assertSame(['firefox', false, ['slowMo' => 100], []], $definition->getArguments());
    }
}
