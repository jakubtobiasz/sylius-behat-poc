<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Admin\Context;

use Alphpaca\SyliusBehat\Shared\Service\SecurityService;
use Behat\Behat\Context\Context;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Webmozart\Assert\Assert;

final class SecurityContext implements Context
{
    public function __construct(
        private readonly SecurityService $adminSecurity,
        private readonly UserRepositoryInterface $adminUserRepository,
    ) {
    }

    /**
     * @Given I am logged in as an administrator
     */
    public function iAmLoggedInAsAnAdministrator(): void
    {
        $this->iAmLoggedInAsAdministrator('sylius@example.com');
    }

    /**
     * @Given /^I am logged in as "([^"]+)" administrator$/
     */
    public function iAmLoggedInAsAdministrator(string $email): void
    {
        $user = $this->adminUserRepository->findOneByEmail($email);
        Assert::notNull($user, sprintf('Administrator with email "%s" does not exist.', $email));

        $this->adminSecurity->logIn($user);
    }
}
