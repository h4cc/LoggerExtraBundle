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

use Silpion\LoggerExtraBundle\Logger\Processor\AdditionsProcessor;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger\Processor\AdditionsProcessor
 */
class AdditionsProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyEntries()
    {
        $processor = new AdditionsProcessor(array());

        $record = array(
          'something' => 'what',
          'extra' => array(
            'bar' => 'baz',
            'timer' => 42,
          ),
        );

        $this->assertEquals($record, $processor->processRecord($record));
    }

    public function testOneEntry()
    {
        $processor = new AdditionsProcessor(array('foo' => 'bar'));

        $record = array(
          'something' => 'what',
          'extra' => array(
            'bar' => 'baz',
            'timer' => 42,
          ),
        );

        $exepectedRecord = array(
          'something' => 'what',
          'extra' => array(
            'bar' => 'baz',
            'timer' => 42,
            'foo' => 'bar'
          ),
        );

        $this->assertEquals($exepectedRecord, $processor->processRecord($record));
    }

    public function testManyEnties()
    {
        $processor = new AdditionsProcessor(array_combine(range('a', 'c'), range('A', 'C')));

        $record = array(
          'something' => 'what',
          'extra' => array(
            'bar' => 'baz',
            'timer' => 42,
          ),
        );

        $exepectedRecord = array(
          'something' => 'what',
          'extra' => array(
            'bar' => 'baz',
            'timer' => 42,
            'a' => 'A',
            'b' => 'B',
            'c' => 'C',
          ),
        );

        $this->assertEquals($exepectedRecord, $processor->processRecord($record));
    }
}
