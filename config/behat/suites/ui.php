<?php

declare(strict_types=1);

use Behat\Config\Config;

return (new Config())
    ->import([
        'ui/admin/viewing_dashboard.php',
        'ui/shop/viewing_homepage.php',
    ])
;
