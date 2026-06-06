<?php

declare(strict_types=1);

$packageRoot = realpath(__DIR__ . '/../../..') ?: __DIR__ . '/../../..';
$vendorBootstrap = $packageRoot . '/vendor/sylius/test-application/config/bootstrap.php';

if (!is_readable($vendorBootstrap)) {
    throw new RuntimeException(
        'Sylius TestApplication is not installed. Install dev dependencies first:'
        . ' composer update sylius/test-application -W'
        . ' (see .github/workflows/build.yaml for the full local Behat setup).',
    );
}

ini_set('memory_limit', '512M');

$playwrightBin = $packageRoot . '/vendor/playwright-php/playwright/bin';
$nodeVersionRaw = trim((string) shell_exec('node --version 2>&1'));
$nodeMajor = preg_match('/v(\d+)/', $nodeVersionRaw, $m) ? (int) $m[1] : 0;

if ($nodeMajor < 20) {
    throw new RuntimeException(sprintf(
        'Node.js 20+ is required for Playwright Behat tests (found %s). '
        . 'Switch with: nvm use 20 (or install Node 20+), then run: vendor/bin/playwright-install --browsers',
        $nodeVersionRaw !== '' ? $nodeVersionRaw : 'unknown',
    ));
}

if (!is_dir($playwrightBin . '/node_modules/playwright')) {
    throw new RuntimeException(
        'Playwright server dependencies are not installed. '
        . 'Run: vendor/bin/playwright-install --browsers',
    );
}

require_once $vendorBootstrap;
