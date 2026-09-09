<?php

/*
 * This file is part of the Sylius 2FA Auth package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\SyliusTwoFactorAuthPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

trait TwoFactorAuthTrait
{
    #[ORM\Column(name: 'google_authenticator_secret', type: 'string', nullable: true)]
    private ?string $googleAuthenticatorSecret = null;

    #[ORM\Column(name: 'email_auth_code', type: 'string', nullable: true)]
    private ?string $emailAuthCode = null;

    public function isTwoFactorActive(): bool
    {
        return $this->isGoogleAuthenticatorEnabled() || $this->isEmailAuthEnabled();
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(?string $googleAuthenticatorSecret): void
    {
        $this->googleAuthenticatorSecret = $googleAuthenticatorSecret;
    }

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return null !== $this->googleAuthenticatorSecret;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        if (is_string($this->username)) {
            return $this->username;
        }

        if (is_string($this->email)) {
            return $this->email;
        }

        return '';
    }

    public function isEmailAuthEnabled(): bool
    {
        return null !== $this->emailAuthCode;
    }

    public function getEmailAuthRecipient(): string
    {
        if (is_string($this->email)) {
            return $this->email;
        }

        return '';
    }

    public function getEmailAuthCode(): string
    {
        if (null === $this->emailAuthCode) {
            return '';
        }

        return $this->emailAuthCode;
    }

    public function setEmailAuthCode(string $authCode): void
    {
        $this->emailAuthCode = $authCode;
    }

    public function disableEmailAuth(): void
    {
        $this->emailAuthCode = null;
    }
}
