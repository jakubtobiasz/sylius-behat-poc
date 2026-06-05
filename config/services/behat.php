<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Context\Setup\AdminSecurityContext;
use Alphpaca\SyliusBehat\Context\Ui\Admin\DashboardContext;
use Alphpaca\SyliusBehat\Service\SecurityService;
use Alphpaca\SyliusBehat\Service\Setter\CookieSetter;
use Alphpaca\SyliusBehat\Service\Setter\CookieSetterInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(CookieSetterInterface::class, CookieSetter::class)
        ->args([
            service('behat.mink.default_session'),
            service('behat.mink.parameters'),
        ])
    ;

    $services->set('alphpaca.behat.admin_security', SecurityService::class)
        ->args([
            service('request_stack'),
            service(CookieSetterInterface::class),
            'admin',
            service('session.factory')->nullOnInvalid(),
        ])
    ;

    $services->set(AdminSecurityContext::class)
        ->args([
            service('alphpaca.behat.admin_security'),
            service('sylius.repository.admin_user'),
        ])
        ->public()
        ->autowire(false)
        ->tag('fob.context_service')
    ;

    $services->set(DashboardContext::class)
        ->public()
        ->autowire()
        ->tag('fob.context_service')
    ;
};
