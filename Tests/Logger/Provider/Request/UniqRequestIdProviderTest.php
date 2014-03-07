<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Tests\Logger\Provider\Request;


use Silpion\LoggerExtraBundle\Logger\Provider\Request\UniqRequestIdProvider;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger\Provider\Request\UniqRequestIdProvider
 */
class UniqRequestIdProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRequestId()
    {
        $provider = new UniqRequestIdProvider();

        // Test for a sha1 hash.
        $this->assertRegExp('@^([a-f0-9]{40})$@', $provider->getRequestId());
    }
}
