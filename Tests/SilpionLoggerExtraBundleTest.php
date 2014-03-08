<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Tests;

use Silpion\LoggerExtraBundle\SilpionLoggerExtraBundle;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\SilpionLoggerExtraBundle
 */
class SilpionLoggerExtraBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $bundle = new SilpionLoggerExtraBundle();

        $this->assertInstanceOf('\Symfony\Component\HttpKernel\Bundle\Bundle', $bundle);
    }
}
 