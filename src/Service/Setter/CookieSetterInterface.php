<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Service\Setter;

interface CookieSetterInterface
{
    public function setCookie(string $name, string $value): void;
}
