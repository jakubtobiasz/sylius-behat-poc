<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Shared\Service\SecurityService;
use Alphpaca\SyliusBehat\Shared\Service\Setter\CookieSetterInterface;

return static function (ContainerConfigurator $container): void {
    $container->import(__DIR__ . '/admin/*.php');

    $services = $container->services();

    $services->set('alphpaca.behat.admin_security', SecurityService::class)
        ->args([
            service('request_stack'),
            service(CookieSetterInterface::class),
            'admin',
            service('session.factory')->nullOnInvalid(),
        ])
    ;
};
