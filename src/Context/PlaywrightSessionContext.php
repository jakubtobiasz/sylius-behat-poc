<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Context;

use Behat\Behat\Context\Context;
use Behat\Mink\MinkAwareContext;
use Behat\Mink\MinkInterface;

/**
 * Optional hook context for Playwright-backed Mink sessions.
 *
 * Sylius suites usually rely on {@see \Sylius\Behat\Context\Hook\SessionContext}
 * for session lifecycle; keep this context only when you need Playwright-specific
 * setup in a suite without Sylius core hooks.
 */
final class PlaywrightSessionContext implements Context, MinkAwareContext
{
    private MinkInterface $mink;

    public function setMink(MinkInterface $mink): void
    {
        $this->mink = $mink;
    }

    public function setMinkParameters(array $parameters): void
    {
    }
}
