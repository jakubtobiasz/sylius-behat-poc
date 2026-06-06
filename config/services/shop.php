<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Shop\Context\HomepageContext;

return static function (ContainerConfigurator $container): void {
    $container->import(__DIR__ . '/shop/pages.php');

    $container->services()
        ->set(HomepageContext::class)
        ->public()
        ->autowire()
        ->tag('fob.context_service')
    ;
};
