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

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Silpion\LoggerExtraBundle\DependencyInjection\SilpionLoggerExtraExtension;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\DependencyInjection\SilpionLoggerExtraExtension
 */
class SilpionLoggerExtraExtensionTest extends AbstractExtensionTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->container->setParameter('kernel.secret', 'my_secret');
    }

    public function testUsingKernelSecret()
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('silpion_logger_extra.secret', 'my_secret');
    }

    public function testAddRequestId()
    {
        $this->load(
          array(
            'request_id' => true,
          )
        );

        $this->assertContainerBuilderHasServiceWithTag(
          'silpion_logger_extra.logger.processor.request_id',
          'monolog.processor'
        );
    }

    public function testAddSessionId()
    {
        $this->load(
          array(
            'session_id' => true,
          )
        );

        $this->assertContainerBuilderHasServiceWithTag(
          'silpion_logger_extra.logger.processor.session_id',
          'monolog.processor'
        );
    }

    public function testAddAdditions()
    {
        $this->load(
          array(
            'additions' => array(
              'foo' => 'bar',
            ),
          )
        );

        $this->assertContainerBuilderHasServiceWithTag(
          'silpion_logger_extra.logger.processor.additions',
          'monolog.processor'
        );
    }

    public function testLoggerOnRequest()
    {
        $this->load(
          array(
            'logger' => array(
              'on_request' => true,
            ),
          )
        );

        $this->assertContainerBuilderHasServiceWithTag(
          'silpion_logger_extra.listener.request',
          'kernel.event_listener'
        );
    }

    public function testLoggerOnResponse()
    {
        $this->load(
          array(
            'logger' => array(
              'on_response' => true,
            ),
          )
        );

        $this->assertContainerBuilderHasServiceWithTag(
          'silpion_logger_extra.listener.response',
          'kernel.event_listener'
        );
    }

    public function testDefaultServices()
    {
        $this->load();

        // Facade
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra',
          'Silpion\LoggerExtraBundle\Logger'
        );

        // Processors
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra.logger.processor.request_id',
          'Silpion\LoggerExtraBundle\Logger\Processor\RequestIdProcessor'
        );
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra.logger.processor.session_id',
          'Silpion\LoggerExtraBundle\Logger\Processor\SessionIdProcessor'
        );
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra.logger.processor.additions',
          'Silpion\LoggerExtraBundle\Logger\Processor\AdditionsProcessor'
        );

        // Provider
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra.logger.provider.request_id',
          'Silpion\LoggerExtraBundle\Logger\Provider\Request\UniqRequestIdProvider'
        );
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra.logger.provider.session_id',
          'Silpion\LoggerExtraBundle\Logger\Provider\Session\SymfonySessionIdProvider'
        );

        // Request Logger
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra.logger.request',
          'Silpion\LoggerExtraBundle\Logger\Request\BasicRequestLogger'
        );
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra.listener.request',
          'Silpion\LoggerExtraBundle\EventListener\KernelRequestListener'
        );

        // Response Logger
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra.logger.response',
          'Silpion\LoggerExtraBundle\Logger\Response\BasicResponseLogger'
        );
        $this->assertContainerBuilderHasServiceWithParameteredClass(
          'silpion_logger_extra.listener.response',
          'Silpion\LoggerExtraBundle\EventListener\KernelResponseListener'
        );
    }

    /**
     * Checking is a service has a tag.
     *
     * @param string $serviceId
     * @param string $tagName
     */
    protected function assertContainerBuilderHasServiceWithTag($serviceId, $tagName)
    {
        $this->assertTrue($this->container->hasDefinition($serviceId), 'Unknown service id: ' . $serviceId);
        $tags = $this->container->getDefinition($serviceId)->getTags();

        $this->assertArrayHasKey($tagName, $tags, 'Missing tag: ' . $tagName);
    }

    /**
     * Assert that a serviceId uses a parameter to use a class.
     * If no parameter name is given, the name of the serviceId suffixed with '.class' will be used.
     *
     * @param string $serviceId
     * @param string $expectedClass
     * @param null $expectedClassParameterValue
     */
    protected function assertContainerBuilderHasServiceWithParameteredClass(
      $serviceId,
      $expectedClass,
      $expectedClassParameterValue = null
    ) {
        if (is_null($expectedClassParameterValue)) {
            // Assume the service has a default class parameter.
            $expectedClassParameterValue = $serviceId . '.class';
        }
        $this->assertContainerBuilderHasService($serviceId, '%' . $expectedClassParameterValue . '%');
        $this->assertContainerBuilderHasParameter($expectedClassParameterValue, $expectedClass);
    }

    protected function getContainerExtensions()
    {
        return array(
          new SilpionLoggerExtraExtension()
        );
    }
}
 