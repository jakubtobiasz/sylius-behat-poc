<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Admin\Page\DashboardPage;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(DashboardPage::class)
        ->parent('alphpaca.behat.symfony_page')
    ;
};
