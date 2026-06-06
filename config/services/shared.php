<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Shared\Service\Setter\CookieSetter;
use Alphpaca\SyliusBehat\Shared\Service\Setter\CookieSetterInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(CookieSetterInterface::class, CookieSetter::class)
        ->args([
            service('behat.mink.default_session'),
            service('behat.mink.parameters'),
        ])
    ;
};
