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


use Silpion\LoggerExtraBundle\Logger\Provider\Request\EnrichedRequestIdProvider;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger\Provider\Request\EnrichedRequestIdProvider
 */
class EnrichedRequestIdProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRequestId()
    {
        $provider = new EnrichedRequestIdProvider();

        // Testing for a hex string, that will end with six times '0'.
        $this->assertRegExp('@^([a-f0-9]{18})000000$@', $provider->getRequestId());
    }
}
