<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    if ('test' !== $container->env()) {
        return;
    }

    $servicesDir = __DIR__ . '/../../../config/services';

    $container->import($servicesDir . '/behat.php');
    $container->import($servicesDir . '/shared.php');
    $container->import($servicesDir . '/admin.php');
    $container->import($servicesDir . '/shop.php');
};
