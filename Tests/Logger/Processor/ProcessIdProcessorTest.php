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

use Silpion\LoggerExtraBundle\Logger\Processor\ProcessIdProcessor;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger\Processor\ProcessIdProcessor
 */
class ProcessIdProcessorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ProcessIdProcessor */
    protected $processor;

    protected function setUp()
    {
        $this->processor = new ProcessIdProcessor();
    }

    public function testDefaultProcessing()
    {
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
            'process_id' => getmypid(),
          ),
        );

        $this->assertEquals($expectedRecord, $this->processor->processRecord($record));
    }

    public function testNotReplacingExistingValue()
    {
        $record = array(
          'foo' => 'bar',
          'extra' => array(
            'process_id' => 'that',
          ),
        );

        $this->assertEquals($record, $this->processor->processRecord($record));
    }
}
