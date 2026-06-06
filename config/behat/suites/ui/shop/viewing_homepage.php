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
                (new Suite('ui_shop_homepage'))
                    ->withContexts(
                        'alphpaca.sylius_behat.shop.context.homepage',
                    )
                    ->withFilter(new TagFilter('@shop_homepage&&@javascript')),
            ),
    )
;
