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

use Scheb\TwoFactorBundle\Security\TwoFactor\Event\TwoFactorAuthenticationEvent;
use Scheb\TwoFactorBundle\Security\TwoFactor\Event\TwoFactorAuthenticationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class TwoFactorAuthenticationLoginAttempt implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            TwoFactorAuthenticationEvents::ATTEMPT => ['onLoginAttempt', 100],
        ];
    }

    public function onLoginAttempt(TwoFactorAuthenticationEvent $event): void
    {
        // @TODO: Make configurable
        $authCodeParamName = '_auth_code';
        $request = $event->getRequest();

        if (!$request->request->has($authCodeParamName)) {
            $authCodeParam = [];
            for ($i = 0; $i < 6; ++$i) {
                $authCodeParamPart = sprintf('%s_%s', $authCodeParamName, $i);
                if (!$request->request->has($authCodeParamPart)) {
                    continue;
                }

                $authCodeParam[] = $request->request->get($authCodeParamPart);
            }

            if (count($authCodeParam) === 6) {
                $request->request->set($authCodeParamName, implode('', $authCodeParam));
            }
        }
    }
}
