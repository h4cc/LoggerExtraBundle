<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Tests\Logger\Provider\Session;


use Silpion\LoggerExtraBundle\Logger\Provider\Session\SymfonySessionIdProvider;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger\Provider\Session\SymfonySessionIdProvider
 */
class SymfonySessionIdProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    protected $sessionProviderMock;

    /** @var SymfonySessionIdProvider */
    protected $provider;

    protected function setUp()
    {
        $this->sessionProviderMock = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session\SessionInterface')
          ->setMethods(array('isStarted', 'getId'))
          ->getMockForAbstractClass();

        $this->provider = new SymfonySessionIdProvider($this->sessionProviderMock, 'secret');
    }

    public function testGetSessionIdWithStartedSession()
    {
        $this->sessionProviderMock->expects($this->once())->method('isStarted')->will($this->returnValue(true));
        $this->sessionProviderMock->expects($this->once())->method('getId')->will($this->returnValue('42'));

        $this->assertEquals(sha1('secret42'), $this->provider->getSessionId());
    }

    public function testGetSessionIdWithoutStartedSession()
    {
        $this->sessionProviderMock->expects($this->once())->method('isStarted')->will($this->returnValue(false));
        $this->sessionProviderMock->expects($this->never())->method('getId');

        $this->assertEquals(null, $this->provider->getSessionId());
    }
}
