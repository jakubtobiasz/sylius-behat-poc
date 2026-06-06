<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Shop\Context;

use Alphpaca\SyliusBehat\Shop\Page\HomepagePage;
use Behat\Behat\Context\Context;

final class HomepageContext implements Context
{
    public function __construct(
        private readonly HomepagePage $homepagePage,
    ) {
    }

    /**
     * @When I view the shop homepage
     */
    public function iViewTheShopHomepage(): void
    {
        $this->homepagePage->open();
    }

    /**
     * @Then the shop homepage should be displayed
     */
    public function theShopHomepageShouldBeDisplayed(): void
    {
        $this->homepagePage->verify();

        if (!$this->homepagePage->hasBody()) {
            throw new \RuntimeException('Expected page to contain a body element.');
        }
    }
}
