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

use BitExpert\SyliusTwoFactorAuthPlugin\Controller\TwoFactorController;
use BitExpert\SyliusTwoFactorAuthPlugin\Form\Type\Google\GoogleSetupFormFlowType;
use BitExpert\SyliusTwoFactorAuthPlugin\Form\Type\Email\EmailSetupFormFlow;
use BitExpert\SyliusTwoFactorAuthPlugin\Mailer\SyliusTwoFactorEnabledMailer;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->defaults()
        ->private();

    $services->set('bitexpert_sylius_2fa.controller', TwoFactorController::class)
        ->abstract()
        ->args([
            '$hookableMetadataFactory' => service('sylius_twig_hooks.factory.hookable_metadata'),
            '$googleAuthenticator' => service('scheb_two_factor.security.google_authenticator'),
            '$codeGenerator' => service('scheb_two_factor.security.email.code_generator'),
            '$tokenStorage' => service('security.token_storage'),
            '$googleFormFlow' => GoogleSetupFormFlowType::class,
            '$emailFormFlow' => EmailSetupFormFlow::class,
        ])
        ->call('setContainer', [service('service_container')]);

    $services->set('bitexpert_sylius_2fa.controller.admin', TwoFactorController::class)
        ->parent('bitexpert_sylius_2fa.controller')
        ->autowire()
        ->autoconfigure()
        ->args([
            '$repository' => service('sylius.repository.admin_user'),
            '$entity' => 'admin_user',
            '$redirectRoute' => 'sylius_admin_dashboard',
            '$template' => '@BitExpertSyliusTwoFactorAuthPlugin/admin/two_factor_setup.html.twig',
        ])
        ->tag('controller.service_arguments');

    $services->set('bitexpert_sylius_2fa.controller.shop', TwoFactorController::class)
        ->parent('bitexpert_sylius_2fa.controller')
        ->autowire()
        ->autoconfigure()
        ->args([
            '$repository' => service('sylius.repository.shop_user'),
            '$entity' => 'shop_user',
            '$redirectRoute' => 'bitexpert_sylius_2fa_shop_account_2fa_overview',
            '$template' => '@BitExpertSyliusTwoFactorAuthPlugin/shop/two_factor_setup.html.twig',
            '$twoFactorEnabledMailer' => service(SyliusTwoFactorEnabledMailer::class),
        ])
        ->tag('controller.service_arguments');
};
