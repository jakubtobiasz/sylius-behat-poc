<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Admin\Context\Ui;

use Alphpaca\SyliusBehat\Admin\Page\DashboardPage;
use Behat\Behat\Context\Context;

final class DashboardContext implements Context
{
    public function __construct(
        private readonly DashboardPage $dashboardPage,
    ) {
    }

    /**
     * @When I open administration dashboard
     */
    public function iOpenAdministrationDashboard(): void
    {
        $this->dashboardPage->open();
    }

    /**
     * @Then I should see the administration dashboard
     */
    public function iShouldSeeTheAdministrationDashboard(): void
    {
        $this->dashboardPage->verify();
    }
}
