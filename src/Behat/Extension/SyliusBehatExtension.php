<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Behat\Extension;

use Alphpaca\SyliusBehat\Behat\Driver\Factory\PlaywrightDriverFactory;
use Behat\MinkExtension\ServiceContainer\MinkExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SyliusBehatExtension implements Extension
{
    public function getConfigKey(): string
    {
        return 'alphpaca_sylius_behat';
    }

    public function initialize(ExtensionManager $extensionManager): void
    {
        $minkExtension = $extensionManager->getExtension('mink');
        if (!$minkExtension instanceof MinkExtension) {
            return;
        }

        $minkExtension->registerDriverFactory(new PlaywrightDriverFactory());
    }

    public function configure(ArrayNodeDefinition $builder): void
    {
    }

    public function load(ContainerBuilder $container, array $config): void
    {
    }

    public function process(ContainerBuilder $container): void
    {
    }
}
