<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class DashboardPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'sylius_admin_dashboard';
    }

    public function hasAdminMenu(): bool
    {
        return null !== $this->getDocument()->find('css', '.sylius-admin-menu');
    }

    /** @return array<string, string> */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'admin_menu' => '.sylius-admin-menu',
        ]);
    }
}
