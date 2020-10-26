<?php

/*
 * This file is part of SkeletonBundle.
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
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
