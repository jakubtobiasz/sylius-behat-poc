<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Alphpaca\SyliusBehat\Page\Admin\DashboardPage;
use Alphpaca\SyliusBehat\Page\Shop\HomepagePage;
use FriendsOfBehat\PageObjectExtension\Page\Page;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('alphpaca.behat.page', Page::class)
        ->abstract()
        ->args([
            service('behat.mink.default_session'),
            service('behat.mink.parameters'),
        ])
    ;

    $services->set('alphpaca.behat.symfony_page', SymfonyPage::class)
        ->abstract()
        ->parent('alphpaca.behat.page')
        ->args([
            service('router'),
        ])
    ;

    $services->set(HomepagePage::class)
        ->parent('alphpaca.behat.symfony_page')
    ;

    $services->set(DashboardPage::class)
        ->parent('alphpaca.behat.symfony_page')
    ;
};
