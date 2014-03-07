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

use Silpion\LoggerExtraBundle\Logger\Processor\RequestIdProcessor;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger\Processor\RequestIdProcessor
 */
class RequestIdProcessorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    protected $providerMock;

    /** @var  RequestIdProcessor */
    protected $processor;

    protected function setUp()
    {
        $this->providerMock = $this->getMockBuilder('Silpion\LoggerExtraBundle\Logger\Provider\RequestIdProvider')
          ->setMethods(array('getRequestId'))
          ->getMockForAbstractClass();

        $this->processor = new RequestIdProcessor($this->providerMock);
    }

    public function testDefaultProcessing()
    {
        $this->providerMock->expects($this->once())->method('getRequestId')->will($this->returnValue('42'));

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
            'request_id' => '42',
          ),
        );

        $this->assertEquals($expectedRecord, $this->processor->processRecord($record));
    }

    public function testNotReplacingExistingValue()
    {
        $this->providerMock->expects($this->never())->method('getRequestId');

        $record = array(
          'foo' => 'bar',
          'extra' => array(
            'request_id' => 'that',
          ),
        );

        $this->assertEquals($record, $this->processor->processRecord($record));
    }
}
