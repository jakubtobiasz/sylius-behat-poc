<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Shop\Context\HomepageContext;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(HomepageContext::class)
        ->public()
        ->autowire()
        ->tag('fob.context_service')
    ;

    $services->alias('alphpaca.sylius_behat.shop.context.homepage', HomepageContext::class)
        ->public()
    ;
};
