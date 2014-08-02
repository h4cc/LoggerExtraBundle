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
          'request_id_provider' => 'Silpion\LoggerExtraBundle\Logger\Provider\Request\UniqRequestIdProvider',
          'session_id' => false,
          'session_id_provider' => 'Silpion\LoggerExtraBundle\Logger\Provider\Session\SymfonySessionIdProvider',
          'session_start' => false,
          'additions' => array(),
          'logger' => array(
            'on_request' => false,
            'on_response' => false,
          ),
        );

        $this->assertProcessedConfigurationEquals(array($config), $processedConfig);
    }

    public function testFullConfig()
    {
        $config = array(
          'request_id' => true,
          'request_id_provider' => 'Silpion\LoggerExtraBundle\Logger\Provider\Request\EnrichedRequestIdProvider',
          'session_id' => true,
          'session_id_provider' => 'Silpion\LoggerExtraBundle\Logger\Provider\Session\SymfonySessionIdProvider',
          'session_start' => true,
          'additions' => array(
            'foo' => 'bar',
            'example' => 42,
          ),
          'logger' => array(
            'on_request' => true,
            'on_response' => true,
          ),
        );
        $processedConfig = array(
          'request_id' => true,
          'request_id_provider' => 'Silpion\LoggerExtraBundle\Logger\Provider\Request\EnrichedRequestIdProvider',
          'session_id' => true,
          'session_id_provider' => 'Silpion\LoggerExtraBundle\Logger\Provider\Session\SymfonySessionIdProvider',
          'session_start' => true,
          'additions' => array(
            'foo' => 'bar',
            'example' => 42,
          ),
          'logger' => array(
            'on_request' => true,
            'on_response' => true,
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
 