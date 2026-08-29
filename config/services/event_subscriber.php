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

use BitExpert\SyliusTwoFactorAuthPlugin\EventSubscriber\AdminUserFormComponentEventSubscriber;
use BitExpert\SyliusTwoFactorAuthPlugin\EventSubscriber\TwoFactorAuthenticationLoginAttempt;
use BitExpert\SyliusTwoFactorAuthPlugin\Menu\ShopAccountMenuListener;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set(TwoFactorAuthenticationLoginAttempt::class, TwoFactorAuthenticationLoginAttempt::class)
        ->tag('kernel.event_subscriber');

    $services->set(AdminUserFormComponentEventSubscriber::class, AdminUserFormComponentEventSubscriber::class)
        ->args([service('security.token_storage')])
        ->tag('kernel.event_subscriber');

    $services->set(ShopAccountMenuListener::class, ShopAccountMenuListener::class)
        ->tag('kernel.event_listener', ['event' => 'sylius.menu.shop.account', 'method' => 'addMenuItem']);
};
