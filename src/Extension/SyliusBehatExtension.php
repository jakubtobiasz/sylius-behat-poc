<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Extension;

use Alphpaca\SyliusBehat\Driver\Factory\PlaywrightDriverFactory;
use Behat\MinkExtension\ServiceContainer\MinkExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SyliusBehatExtension implements Extension
{
    private bool $minkExtensionFound = false;

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
        $this->minkExtensionFound = true;
    }

    public function configure(ArrayNodeDefinition $builder): void
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('javascript_session')->defaultValue('playwright')->end()
            ->end()
        ;
    }

    public function load(ContainerBuilder $container, array $config): void
    {
        $container->setParameter('alphpaca_sylius_behat.javascript_session', $config['javascript_session']);
        $container->setParameter('alphpaca_sylius_behat.mink_extension_found', $this->minkExtensionFound);
    }

    public function process(ContainerBuilder $container): void
    {
    }
}
