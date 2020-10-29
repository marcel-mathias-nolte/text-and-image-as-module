<?php

/*
 * This file is part of ContaoTextAndImageAsModuleBundle.
 *
 * @package   ContaoTextAndImageAsModuleBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015-2020
 * @website	  https://github.com/marcel-mathias-nolte
 * @license   LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\Tests;

use PHPUnit\Framework\TestCase;

class ContaoTextAndImageAsModuleBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoTextAndImageAsModuleBundle();

        $this->assertInstanceOf('MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\ContaoTextAndImageAsModuleBundle', $bundle);
    }
}
