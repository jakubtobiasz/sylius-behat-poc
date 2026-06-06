<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Shared\Service\Setter\CookieSetter;
use Alphpaca\SyliusBehat\Shared\Service\Setter\CookieSetterInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
};
