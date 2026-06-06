<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Shop\Page\HomepagePage;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(HomepagePage::class)
        ->parent('alphpaca.behat.symfony_page')
    ;
};
