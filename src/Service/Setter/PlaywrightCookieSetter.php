<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Service\Setter;

use Playwright\Browser\BrowserContextInterface;
use Playwright\Mink\Driver\PlaywrightDriver;

/**
 * Sets cookies on Playwright's browser context without going through Mink's driver.
 *
 * playwright-mink's PlaywrightDriver is final and URL-encodes cookie values while
 * scoping them to the current page URL. Symfony mock-file sessions need the raw
 * session ID on path "/".
 */
final class PlaywrightCookieSetter
{
    public static function setCookie(PlaywrightDriver $driver, string $name, string $value, string $baseUrl): void
    {
        if (!$driver->isStarted()) {
            $driver->start();
        }

        $host = parse_url($baseUrl, \PHP_URL_HOST) ?: '127.0.0.1';

        self::browserContext($driver)->addCookies([[
            'name' => $name,
            'value' => $value,
            'domain' => $host,
            'path' => '/',
        ]]);
    }

    private static function browserContext(PlaywrightDriver $driver): BrowserContextInterface
    {
        $property = new \ReflectionProperty(PlaywrightDriver::class, 'context');
        $property->setAccessible(true);

        /** @var BrowserContextInterface $context */
        $context = $property->getValue($driver);

        return $context;
    }
}
