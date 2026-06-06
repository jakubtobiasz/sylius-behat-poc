<?php

declare(strict_types=1);

use Behat\Config\Config;
use Behat\Config\Filter\TagFilter;
use Behat\Config\Profile;
use Behat\Config\Suite;

return (new Config())
    ->withProfile(
        (new Profile('default'))
            ->withSuite(
                (new Suite('ui_admin_dashboard'))
                    ->withContexts(
                        'alphpaca.sylius_behat.admin.context.security',
                        'alphpaca.sylius_behat.admin.context.dashboard',
                    )
                    ->withFilter(new TagFilter('@admin_dashboard&&@javascript')),
            ),
    )
;
