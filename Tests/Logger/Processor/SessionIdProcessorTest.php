<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Tests\Logger\Processor;

use Silpion\LoggerExtraBundle\Logger\Processor\SessionIdProcessor;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger\Processor\SessionIdProcessor
 */
class SessionIdProcessorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    protected $providerMock;

    /** @var  SessionIdProcessor */
    protected $processor;

    protected function setUp()
    {
        $this->providerMock = $this->getMockBuilder('Silpion\LoggerExtraBundle\Logger\Provider\SessionIdProvider')
          ->setMethods(array('getSessionId'))
          ->getMockForAbstractClass();

        $this->processor = new SessionIdProcessor($this->providerMock);
    }

    public function testDefaultProcessing()
    {
        $this->providerMock->expects($this->once())->method('getSessionId')->will($this->returnValue('42'));

        $record = array(
          'foo' => 'bar',
          'extra' => array(
            'this' => 'that',
          ),
        );

        $expectedRecord = array(
          'foo' => 'bar',
          'extra' => array(
            'this' => 'that',
            'session_id' => '42',
          ),
        );

        $this->assertEquals($expectedRecord, $this->processor->processRecord($record));
    }

    public function testNotReplacingExistingValue()
    {
        $this->providerMock->expects($this->never())->method('getSessionId');

        $record = array(
          'foo' => 'bar',
          'extra' => array(
            'session_id' => 'that',
          ),
        );

        $this->assertEquals($record, $this->processor->processRecord($record));
    }
}
