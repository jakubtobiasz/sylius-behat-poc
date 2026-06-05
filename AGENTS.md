# AGENTS.md — Sylius Behat

Guidance for coding agents working in this repository.

## What this is

`alphpaca/sylius-behat` is a **PHP library** that provides **Sylius Behat** contexts, page objects, and step definitions using **Playwright PHP** as the browser driver (via `playwright-php/playwright-mink`).

- **Package:** `alphpaca/sylius-behat`
- **Namespace:** `Alphpaca\SyliusBehat\`
- **PHP:** >= 8.2
- **Browser stack:** `playwright-php/playwright` + `playwright-php/playwright-mink`
- **Behat:** `behat/behat` ^3.14, `friends-of-behat/mink-extension` ^2.7

This package **replaces** `Sylius\Behat` from `sylius/sylius`. It cannot run alongside Sylius' built-in Behat suite — disable or remove Sylius Behat configuration (contexts, suites, Mink sessions) in the consuming app before wiring this package.

## Repository layout

```
sylius-behat/
├── src/
│   ├── Context/              # Behat contexts (step definitions)
│   ├── Page/                 # Page objects (Alphpaca-owned base classes)
│   ├── Driver/Factory/       # Playwright Mink driver factory
│   └── Extension/            # Behat extension (registers playwright driver)
├── example/                  # Sylius consumer app ([Sylius/TestApplication](https://github.com/Sylius/TestApplication))
├── behat.yml.dist            # Minimal Behat + Mink example
├── composer.json
├── PHPUNIT.md                # PHPUnit rules for agents
└── README.md
```

## Architectural rules

### Playwright driver registration

- `Alphpaca\SyliusBehat\Extension\SyliusBehatExtension` registers `PlaywrightDriverFactory` with `Behat\MinkExtension` during `initialize()`.
- Driver key in Behat config: **`playwright`** (javascript-capable session).
- Factory class: `Alphpaca\SyliusBehat\Driver\Factory\PlaywrightDriverFactory`.
- Underlying driver: `Playwright\Mink\Driver\PlaywrightDriver`.

### Contexts

| Topic | Rule |
|-------|------|
| Namespace | `Alphpaca\SyliusBehat\Context\…` |
| Interface | Implement `Behat\Behat\Context\Context` |
| Sylius apps | Register as Symfony services with `fob.context_service` tag when using FriendsOfBehat SymfonyExtension |
| Assertions | Keep assertions in contexts; page objects expose interaction methods only |
| Sylius core | Do **not** import or extend `Sylius\Behat\Context\…` — reimplement needed setup/hooks/transformers here |

### Page objects

| Topic | Rule |
|-------|------|
| Namespace | `Alphpaca\SyliusBehat\Page\…` |
| Base classes | Use Alphpaca page base classes only — do **not** extend `Sylius\Behat\Page\…` |
| DOM access | Use Mink session via page helpers (`getSession()`, element maps) |
| Routes | Resolve URLs from Symfony route names in Alphpaca page classes |

### Steps / features

- Gherkin features for package development live under `example/` (Sylius TestApplication).
- Step text should match established Sylius Behat conventions where possible (`When I add it`, `Then I should be notified that …`).

## Behat configuration (consumer)

Consumers enable:

```yaml
extensions:
    Behat\MinkExtension:
        default_session: symfony
        javascript_session: playwright
        sessions:
            symfony:
                symfony: ~
            playwright:
                playwright:
                    browser_type: chromium
                    headless: true
    Alphpaca\SyliusBehat\Extension\SyliusBehatExtension: ~
```

`@javascript` scenarios use the `playwright` session.

## Out of scope unless explicitly requested

- Docker Compose, CI workflows, Packagist publish automation
- Selenium2 / Panther driver support (Playwright only)

## PHPUnit

See [PHPUNIT.md](PHPUNIT.md). Key rule: **always** `$this->assert…`, never `self::assert…`.

## Conventions

- `declare(strict_types=1);` on all PHP files
- PSR-4 autoloading under `Alphpaca\SyliusBehat\`
- MIT license
- Conventional Commits for git messages

## Related packages

- [playwright-php/playwright](https://github.com/playwright-php/playwright) — browser automation
- [playwright-php/playwright-mink](https://github.com/playwright-php/playwright-mink) — Mink driver
- [playwright-php/setup-playwright](https://github.com/playwright-php/setup-playwright) — CI browser setup
- [Sylius/TestApplication](https://github.com/Sylius/TestApplication) — example Sylius app for this package
- [FriendsOfBehat SymfonyExtension](https://github.com/FriendsOfBehat/SymfonyExtension) — Symfony kernel + Mink in Behat
