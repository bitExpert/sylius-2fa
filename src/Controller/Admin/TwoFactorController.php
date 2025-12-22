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

namespace BitExpert\SyliusTwoFactorAuthPlugin\Controller\Admin;

use Sylius\Component\Core\Model\AdminUser;
use Sylius\Resource\Metadata\Metadata;
use Sylius\TwigHooks\Bag\DataBag;
use Sylius\TwigHooks\Bag\ScalarDataBag;
use Sylius\TwigHooks\Hook\Metadata\HookMetadata;
use Sylius\TwigHooks\Hookable\HookableTemplate;
use Sylius\TwigHooks\Hookable\Metadata\HookableMetadataFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class TwoFactorController extends AbstractController
{
    public function __construct(
        private readonly HookableMetadataFactoryInterface $hookableMetadataFactory
    ) {
    }

    public function setup(): Response
    {
        $metadata = Metadata::fromAliasAndConfiguration('sylius.admin_user', ['driver' => 'doctrine/orm']);

        $resource = new AdminUser();

        $hookMetadata = new HookMetadata('admin_user', new DataBag(['applicationName' => 'sylius']));
        $hookable = new HookableTemplate('admin_user', 'show', '', ['applicationName' => 'sylius'], ['resource_name' => 'admin_user']);
        $hookableMetadata = $this->hookableMetadataFactory->create(
            $hookMetadata,
            new DataBag(['resource' => $resource]),
            /** @phpstan-ignore-next-line */
            new ScalarDataBag($hookable->configuration),
            [],
        );

        return $this->render('@BitExpertSyliusTwoFactorAuthPlugin/admin/two_factor_setup/setup.html.twig', [
            'configuration' => $hookableMetadata->configuration,
            'metadata' => $metadata,
            'resource' => $resource,
        ]);
    }
}
