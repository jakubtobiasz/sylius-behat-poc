<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Page\Shop;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class HomepagePage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'sylius_shop_homepage';
    }

    public function hasBody(): bool
    {
        return null !== $this->getDocument()->find('css', 'body');
    }
}
