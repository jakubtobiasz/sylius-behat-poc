<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Driver\Factory;

use Behat\MinkExtension\ServiceContainer\Driver\DriverFactory;
use Playwright\Mink\Driver\PlaywrightDriver;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;

final class PlaywrightDriverFactory implements DriverFactory
{
    public function getDriverName(): string
    {
        return 'playwright';
    }

    public function supportsJavascript(): bool
    {
        return true;
    }

    public function configure(ArrayNodeDefinition $builder): void
    {
        $builder
            ->children()
                ->scalarNode('browser_type')
                    ->defaultValue('chromium')
                    ->info('One of: chromium, firefox, webkit')
                ->end()
                ->booleanNode('headless')->defaultTrue()->end()
                ->variableNode('launch_options')
                    ->defaultValue([])
                    ->info('Playwright browser launch options')
                ->end()
                ->variableNode('context_options')
                    ->defaultValue([])
                    ->info('Playwright browser context options')
                ->end()
            ->end()
        ;
    }

    public function buildDriver(array $config): Definition
    {
        if (!class_exists(PlaywrightDriver::class)) {
            throw new \RuntimeException(
                'Install "playwright-php/playwright-mink" in order to use the "playwright" driver.'
            );
        }

        return new Definition(PlaywrightDriver::class, [
            $config['browser_type'],
            $config['headless'],
            $config['launch_options'],
            $config['context_options'],
        ]);
    }
}
