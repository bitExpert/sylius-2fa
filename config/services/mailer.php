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

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use BitExpert\SyliusTwoFactorAuthPlugin\Mailer\SyliusAuthCodeMailer;
use BitExpert\SyliusTwoFactorAuthPlugin\Mailer\SyliusTwoFactorEnabledMailer;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set(SyliusAuthCodeMailer::class, SyliusAuthCodeMailer::class)
        ->args([
            service('sylius.email_sender'),
            service('sylius.context.channel'),
            service('sylius.context.locale'),
        ]);

    $services->set(SyliusTwoFactorEnabledMailer::class, SyliusTwoFactorEnabledMailer::class)
        ->args([
            service('mailer'),
            service('sylius.context.channel'),
            service('sylius.context.locale'),
            service('logger'),
            service('twig'),
            service('translator'),
        ]);
};
