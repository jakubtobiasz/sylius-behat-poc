<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Admin\Context\DashboardContext;
use Alphpaca\SyliusBehat\Admin\Context\SecurityContext;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(DashboardContext::class)
        ->public()
        ->autowire()
        ->tag('fob.context_service')
    ;

    $services->alias('alphpaca.sylius_behat.admin.context.dashboard', DashboardContext::class)
        ->public()
    ;

    $services->set(SecurityContext::class)
        ->args([
            service('alphpaca.behat.admin_security'),
            service('sylius.repository.admin_user'),
        ])
        ->public()
        ->autowire(false)
        ->tag('fob.context_service')
    ;

    $services->alias('alphpaca.sylius_behat.admin.context.security', SecurityContext::class)
        ->public()
    ;
};
