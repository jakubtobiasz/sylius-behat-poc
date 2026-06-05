<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Service\Setter;

use Behat\Mink\Session;
use FriendsOfBehat\SymfonyExtension\Driver\SymfonyDriver;
use Playwright\Mink\Driver\PlaywrightDriver;
use Symfony\Component\BrowserKit\Cookie;

final class CookieSetter implements CookieSetterInterface
{
    public function __construct(
        private readonly Session $minkSession,
        private readonly \ArrayAccess $minkParameters,
    ) {
    }

    public function setCookie(string $name, string $value): void
    {
        $driver = $this->minkSession->getDriver();

        $this->prepareMinkSessionIfNeeded();

        if ($driver instanceof SymfonyDriver) {
            $driver->getClient()->getCookieJar()->set(
                new Cookie(
                    $name,
                    $value,
                    null,
                    '/',
                    parse_url((string) $this->minkParameters['base_url'], \PHP_URL_HOST),
                ),
            );

            return;
        }

        if ($driver instanceof PlaywrightDriver) {
            PlaywrightCookieSetter::setCookie(
                $driver,
                $name,
                $value,
                rtrim((string) $this->minkParameters['base_url'], '/') . '/',
            );

            return;
        }

        $this->minkSession->setCookie($name, $value);
    }

    private function prepareMinkSessionIfNeeded(): void
    {
        $driver = $this->minkSession->getDriver();

        if ($driver instanceof SymfonyDriver) {
            return;
        }

        if ($driver instanceof PlaywrightDriver && !$driver->isStarted()) {
            $driver->start();
        }

        $baseUrl = rtrim((string) $this->minkParameters['base_url'], '/');
        $currentUrl = $this->minkSession->getCurrentUrl();

        if ('' === $currentUrl || 'about:blank' === $currentUrl || !str_contains($currentUrl, $baseUrl)) {
            $this->minkSession->visit($baseUrl . '/');
        }
    }
}
