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

namespace BitExpert\SyliusTwoFactorAuthPlugin\EventSubscriber;

use BitExpert\SyliusTwoFactorAuthPlugin\Entity\TwoFactorAuthInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\AdminUserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class AdminUserActivateTwoFactor implements EventSubscriberInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            'sylius.admin_user.post_update' => ['activateToTwoFactor', 25],
        ];
    }

    public function activateToTwoFactor(ResourceControllerEvent $event): void
    {
        /** @var AdminUserInterface&TwoFactorAuthInterface $user */
        $user = $event->getSubject();

        if(!$user->isTwoFactorActive()) {return;
        }

        $url = $this->urlGenerator->generate('bitexpert_sylius_2fa_admin_setup_2fa');
        $event->setResponse(new RedirectResponse($url));
    }
}
