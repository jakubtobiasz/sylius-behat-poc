<?php

declare(strict_types=1);

use Symfony\Component\Process\Process;

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

// #region agent log
$debugLogPath = $packageRoot . '/.cursor/debug-2cf8dc.log';
$debugLog = static function (string $hypothesisId, string $location, string $message, array $data) use ($debugLogPath): void {
    file_put_contents($debugLogPath, json_encode([
        'sessionId' => '2cf8dc',
        'runId' => 'pre-fix',
        'hypothesisId' => $hypothesisId,
        'location' => $location,
        'message' => $message,
        'data' => $data,
        'timestamp' => (int) round(microtime(true) * 1000),
    ], JSON_THROW_ON_ERROR) . "\n", FILE_APPEND);
};
$playwrightBin = $packageRoot . '/vendor/playwright-php/playwright/bin';
$nodeVersionRaw = trim((string) shell_exec('node --version 2>&1'));
$nodeMajor = preg_match('/v(\d+)/', $nodeVersionRaw, $m) ? (int) $m[1] : 0;
$debugLog('C', 'behat_bootstrap.php:node', 'Node.js version check', [
    'nodeVersion' => $nodeVersionRaw,
    'nodeMajor' => $nodeMajor,
    'meetsMin20' => $nodeMajor >= 20,
    'whichNode' => trim((string) shell_exec('which node 2>&1')),
]);
$debugLog('B', 'behat_bootstrap.php:npm', 'Playwright npm package check', [
    'playwrightModuleExists' => is_dir($playwrightBin . '/node_modules/playwright'),
    'nodeModulesExists' => is_dir($playwrightBin . '/node_modules'),
    'serverScriptExists' => is_file($playwrightBin . '/playwright-server.js'),
]);
$debugLog('A', 'behat_bootstrap.php:browsers', 'Playwright browser cache check', [
    'msPlaywrightCache' => getenv('PLAYWRIGHT_BROWSERS_PATH') ?: (getenv('HOME') . '/.cache/ms-playwright'),
    'cacheExists' => is_dir(getenv('PLAYWRIGHT_BROWSERS_PATH') ?: (getenv('HOME') . '/.cache/ms-playwright')),
]);
$serverProbe = new Process(['node', $playwrightBin . '/playwright-server.js'], $playwrightBin);
$serverProbe->setTimeout(3);
$serverProbe->run();
$debugLog('E', 'behat_bootstrap.php:server', 'playwright-server.js probe', [
    'exitCode' => $serverProbe->getExitCode(),
    'stderrExcerpt' => substr($serverProbe->getErrorOutput(), 0, 500),
]);

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
// #endregion

require_once $vendorBootstrap;
