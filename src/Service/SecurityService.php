<?php

declare(strict_types=1);

namespace Alphpaca\SyliusBehat\Service;

use Alphpaca\SyliusBehat\Service\Setter\CookieSetterInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

final class SecurityService
{
    private readonly string $sessionTokenVariable;

    private readonly string $firewallContextName;

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly CookieSetterInterface $cookieSetter,
        string $firewallContextName,
        private readonly ?SessionFactoryInterface $sessionFactory = null,
    ) {
        $this->firewallContextName = $firewallContextName;
        $this->sessionTokenVariable = sprintf('_security_%s', $firewallContextName);
    }

    public function logIn(UserInterface $user): void
    {
        if (3 === (new \ReflectionClass(UsernamePasswordToken::class))->getConstructor()->getNumberOfParameters()) {
            $token = new UsernamePasswordToken($user, $this->firewallContextName, $user->getRoles());
        } else {
            $token = new UsernamePasswordToken($user, $user->getPassword(), $this->firewallContextName, $user->getRoles());
        }

        $this->setToken($token);
    }

    public function logOut(): void
    {
        try {
            $this->setTokenCookie();
        } catch (SessionNotFoundException) {
        }
    }

    private function setToken(TokenInterface $token): void
    {
        if (null !== $this->sessionFactory) {
            $session = $this->sessionFactory->createSession();
            $request = new Request();
            $request->setSession($session);
            $this->requestStack->push($request);
        }

        $this->setTokenCookie(serialize($token));
    }

    private function setTokenCookie(?string $serializedToken = null): void
    {
        $session = $this->requestStack->getSession();

        if (!$session->isStarted()) {
            $session->start();
        }

        $session->set($this->sessionTokenVariable, $serializedToken);
        $session->save();
        $this->cookieSetter->setCookie($session->getName(), $session->getId());
    }
}
