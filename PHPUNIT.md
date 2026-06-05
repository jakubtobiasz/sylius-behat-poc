# PHPUNIT.md — PHPUnit rules

Agent rules for PHPUnit tests in this repository.

## Assertions

Always use instance syntax in test classes:

```php
$this->assertSame('playwright', $factory->getDriverName());
$this->assertTrue($factory->supportsJavascript());
```

Do **not** use static syntax:

```php
// forbidden
self::assertSame(...);
static::assertSame(...);
TestCase::assertSame(...);
```

`TestCase` assertion methods are instance methods — `$this->assert…` matches PHPUnit convention and keeps tests consistent across the repo.

## Test classes

- Extend `PHPUnit\Framework\TestCase` (or a project-specific base test case).
- One test class per subject under test; file path mirrors `src/` under `tests/`.
- Method names: `test…` or `#[Test]` attribute (PHPUnit 10+).
- `declare(strict_types=1);` on every test file.

## Structure

- Arrange–act–assert; no logic in assertions beyond what's needed to compare.
- Prefer focused tests over multi-scenario methods.
- Use data providers when the same assertion repeats with different inputs.

## What to test here

- Driver factories, extension wiring, and other package logic with fast unit tests.
- Browser / Behat integration tests belong under `example/` once TestApplication is wired — not in root `tests/` unless explicitly scoped as unit tests with mocks.
