<?php

/*
 * This file is part of SkeletonBundle.
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\ContaoTextAndImageAsModuleBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoTextAndImageAsModuleBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
