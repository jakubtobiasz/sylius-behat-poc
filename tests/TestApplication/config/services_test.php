<?php

declare(strict_types=1);

use Alphpaca\SyliusBehat\Context\Ui\Shop\HomepageContext;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    if ('test' !== $container->env()) {
        return;
    }

    $container->import(__DIR__ . '/../../../config/services/pages.php');
    $container->import(__DIR__ . '/../../../config/services/behat.php');

    $container->services()
        ->set(HomepageContext::class)
        ->public()
        ->autowire()
        ->tag('fob.context_service')
    ;
};
