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

use BitExpert\SyliusTwoFactorAuthPlugin\Grid\AdminUserGridListener;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set(AdminUserGridListener::class, AdminUserGridListener::class)
        ->public()
        ->tag('kernel.event_listener', ['event' => 'sylius.grid.admin_admin_user', 'method' => 'addField']);
};
