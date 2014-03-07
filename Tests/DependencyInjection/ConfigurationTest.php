<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Tests\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\AbstractConfigurationTestCase;
use Silpion\LoggerExtraBundle\DependencyInjection\Configuration;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\DependencyInjection\Configuration
 */
class ConfigurationTest extends AbstractConfigurationTestCase
{
    public function testMinimumConfig()
    {
        $config = array();
        $processedConfig = array(
          'request_id' => false,
          'session_id' => false,
          'additions' => array(),
        );

        $this->assertProcessedConfigurationEquals(array($config), $processedConfig);
    }

    public function testFullConfig()
    {
        $config = array(
          'request_id' => true,
          'session_id' => true,
          'additions' => array(
            'foo' => 'bar',
            'example' => 42,
          ),
        );
        $processedConfig = array(
          'request_id' => true,
          'session_id' => true,
          'additions' => array(
            'foo' => 'bar',
            'example' => 42,
          ),
        );

        $this->assertProcessedConfigurationEquals(array($config), $processedConfig);
    }

    /**
     * Return the instance of ConfigurationInterface that should be used by the
     * Configuration-specific assertions in this test-case
     *
     * @return \Symfony\Component\Config\Definition\ConfigurationInterface
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
 