# Alphpaca Sylius Behat

**Sylius Behat** contexts, page objects, and step definitions backed by [Playwright PHP](https://github.com/playwright-php/playwright) and [playwright-mink](https://github.com/playwright-php/playwright-mink).

Replaces `Sylius\Behat` from `sylius/sylius` and Selenium2 / Panther for `@javascript` scenarios. Disable Sylius' built-in Behat configuration before adopting this package.

## Requirements

- PHP 8.2+
- Node.js 20+ (Playwright browser server)
- Composer

## Installation

```bash
composer require --dev alphpaca/sylius-behat
```

Install Playwright browsers after Composer install:

```bash
vendor/bin/playwright-install --browsers
```

For CI, use [playwright-php/setup-playwright](https://github.com/playwright-php/setup-playwright):

```yaml
- uses: playwright-php/setup-playwright@v1
  with:
    browsers: chromium
```

## Behat configuration

Behat configuration is PHP-based (`behat.php` / `behat.dist.php`). Enable the extension and register a Playwright Mink session:

```php
<?php

declare(strict_types=1);

use Alphpaca\SyliusBehat\Behat\Extension\SyliusBehatExtension;
use Behat\Config\Config;
use Behat\Config\Extension;
use Behat\Config\Profile;
use Behat\MinkExtension\ServiceContainer\MinkExtension;
use FriendsOfBehat\SymfonyExtension\ServiceContainer\SymfonyExtension;

return (new Config())
    ->withProfile(
        (new Profile('default'))
            ->withExtension(new Extension(MinkExtension::class, [
                'base_url' => '%env(string:SYLIUS_BEHAT_BASE_URL)%',
                'default_session' => 'symfony',
                'javascript_session' => 'playwright',
                'sessions' => [
                    'symfony' => ['symfony' => null],
                    'playwright' => [
                        'playwright' => [
                            'browser_type' => 'chromium',
                            'headless' => true,
                        ],
                    ],
                ],
            ]))
            ->withExtension(new Extension(SymfonyExtension::class, [
                'kernel' => ['environment' => 'test'],
            ]))
            ->withExtension(new Extension(SyliusBehatExtension::class)),
    );
```

Register contexts as Symfony services tagged `fob.context_service`, then reference them by service id in suite definitions under `config/behat/suites/`.

Tag scenarios that need a real browser with `@javascript`. Mink will switch to the `playwright` session automatically.

See [`behat.dist.php`](behat.dist.php) and [`config/behat/suites.php`](config/behat/suites.php) for a minimal example.

## Package layout

```
src/
├── Context/          # Behat step definitions (UI, setup, transform)
├── Page/             # Page objects (Alphpaca-owned)
├── Driver/           # Playwright Mink driver factory
└── Extension/        # Behat extension (registers the playwright driver)
```

Namespace: `Alphpaca\SyliusBehat\`.

## Example application

Development and smoke tests use [Sylius/TestApplication](https://github.com/Sylius/TestApplication) under `example/` (path repository consumer). Sylius' default Behat suite must be removed or disabled there before this package is wired in.

## License

MIT — see [LICENSE](LICENSE).
