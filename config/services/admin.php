<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Admin\Context\Ui\DashboardContext;
use Alphpaca\SyliusBehat\Shared\Service\SecurityService;
use Alphpaca\SyliusBehat\Shared\Service\Setter\CookieSetter;
use Alphpaca\SyliusBehat\Shared\Service\Setter\CookieSetterInterface;

return static function (ContainerConfigurator $container): void {
    $container->import(__DIR__ . '/admin/pages.php');

    $services = $container->services();

    $services->set('alphpaca.behat.admin_security', SecurityService::class)
        ->args([
            service('request_stack'),
            service(CookieSetterInterface::class),
            'admin',
            service('session.factory')->nullOnInvalid(),
        ])
    ;

    $services->set(DashboardContext::class)
        ->public()
        ->autowire()
        ->tag('fob.context_service')
    ;

    $services->set(CookieSetterInterface::class, CookieSetter::class)
        ->args([
            service('behat.mink.default_session'),
            service('behat.mink.parameters'),
        ])
    ;
};
