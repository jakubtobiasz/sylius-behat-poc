<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Shared\Service\Setter;

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
            // #region agent log
            $debugLogPath = dirname(__DIR__, 4) . '/.cursor/debug-2cf8dc.log';
            file_put_contents($debugLogPath, json_encode([
                'sessionId' => '2cf8dc',
                'runId' => 'pre-fix',
                'hypothesisId' => 'D',
                'location' => 'CookieSetter.php:prepareMinkSessionIfNeeded',
                'message' => 'About to start PlaywrightDriver',
                'data' => [
                    'driverClass' => $driver::class,
                    'isStarted' => $driver->isStarted(),
                    'path' => getenv('PATH'),
                ],
                'timestamp' => (int) round(microtime(true) * 1000),
            ], JSON_THROW_ON_ERROR) . "\n", FILE_APPEND);
            // #endregion
            try {
                $driver->start();
            } catch (\Throwable $e) {
                // #region agent log
                file_put_contents($debugLogPath, json_encode([
                    'sessionId' => '2cf8dc',
                    'runId' => 'pre-fix',
                    'hypothesisId' => 'E',
                    'location' => 'CookieSetter.php:prepareMinkSessionIfNeeded',
                    'message' => 'PlaywrightDriver start failed',
                    'data' => [
                        'exceptionClass' => $e::class,
                        'exceptionMessage' => $e->getMessage(),
                        'previousMessage' => $e->getPrevious()?->getMessage(),
                    ],
                    'timestamp' => (int) round(microtime(true) * 1000),
                ], JSON_THROW_ON_ERROR) . "\n", FILE_APPEND);
                // #endregion
                throw $e;
            }
        }

        $baseUrl = rtrim((string) $this->minkParameters['base_url'], '/');
        $currentUrl = $this->minkSession->getCurrentUrl();

        if ('' === $currentUrl || 'about:blank' === $currentUrl || !str_contains($currentUrl, $baseUrl)) {
            $this->minkSession->visit($baseUrl . '/');
        }
    }
}
