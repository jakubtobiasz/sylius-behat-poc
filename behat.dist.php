<?php

declare(strict_types=1);

use Alphpaca\SyliusBehat\Behat\Extension\SyliusBehatExtension;
use Behat\Config\Config;
use Behat\Config\Extension;
use Behat\Config\Filter\TagFilter;
use Behat\Config\GherkinOptions;
use Behat\Config\Profile;
use Behat\Config\TesterOptions;
use Behat\MinkExtension\ServiceContainer\MinkExtension;
use FriendsOfBehat\SuiteSettingsExtension\ServiceContainer\SuiteSettingsExtension;
use FriendsOfBehat\SymfonyExtension\ServiceContainer\SymfonyExtension;

return (new Config())
    ->import('config/behat/suites.php')
    ->withProfile(
        (new Profile('default'))
            ->withTesterOptions(
                (new TesterOptions())
                    ->withErrorReporting(E_ALL & ~(E_DEPRECATED | E_USER_DEPRECATED)),
            )
            ->withGherkinOptions(
                (new GherkinOptions())
                    ->withFilter(new TagFilter('~@todo')),
            )
            ->withExtension(new Extension(MinkExtension::class, [
                'base_url' => 'http://127.0.0.1:8000',
                'default_session' => 'playwright',
                'javascript_session' => 'playwright',
                'sessions' => [
                    'playwright' => [
                        'playwright' => [
                            'browser_type' => 'chromium',
                            'headless' => true,
                        ],
                    ],
                ],
            ]))
            ->withExtension(new Extension(SymfonyExtension::class, [
                'bootstrap' => 'tests/TestApplication/config/behat_bootstrap.php',
                'kernel' => [
                    'class' => 'Sylius\TestApplication\Kernel',
                    'environment' => 'test',
                ],
            ]))
            ->withExtension(new Extension(SuiteSettingsExtension::class, [
                'paths' => ['%paths.base%/tests/TestApplication/features'],
            ]))
            ->withExtension(new Extension(SyliusBehatExtension::class)),
    )
;
