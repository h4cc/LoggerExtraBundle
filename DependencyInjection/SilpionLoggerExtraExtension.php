<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Extension for Bundle.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class SilpionLoggerExtraExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        // Use global "secret" if available.
        if ($container->hasParameter('kernel.secret')) {
            $container->setParameter('silpion_logger_extra.secret', $container->getParameter('kernel.secret'));
        }

        $container->setParameter('silpion_logger_extra.logger.provider.session_id.session_start', $config['session_start']);

        $container->setParameter('silpion_logger_extra.logger.provider.request_id.class', $config['request_id_provider']);
        $container->setParameter('silpion_logger_extra.logger.provider.session_id.class', $config['session_id_provider']);

        $this->addMonologProcessors($container, $config);
        $this->addAdditions($container, $config['additions']);
        $this->addLogger($container, $config['logger']);
    }

    protected function addMonologProcessors(ContainerBuilder $container, array $config)
    {
        // Activate adding if request_id if enabled.
        if ($config['request_id']) {
            $container->getDefinition('silpion_logger_extra.logger.processor.request_id')
              ->addTag('monolog.processor', array('method' => 'processRecord'));
        }

        // Activate adding if session_id if enabled.
        if ($config['session_id']) {
            $container->getDefinition('silpion_logger_extra.logger.processor.session_id')
              ->addTag('monolog.processor', array('method' => 'processRecord'));
        }
    }

    protected function addAdditions(ContainerBuilder $container, array $additions)
    {
        // Add additions if any defined.
        if ($additions) {
            $container->getDefinition('silpion_logger_extra.logger.processor.additions')
              ->addTag('monolog.processor', array('method' => 'processRecord'))
              ->replaceArgument(0, $additions);
        }
    }

    protected function addLogger(ContainerBuilder $container, array $config)
    {
        // Add a logger for each incoming request.
        if ($config['on_request']) {
            $container->getDefinition('silpion_logger_extra.listener.request')->addTag(
              'kernel.event_listener',
              array(
                'event' => 'kernel.request',
                'method' => 'onKernelRequest',
                'priority' => 500
              )
            );
        }

        // Add a logger for each outgoing response.
        if ($config['on_response']) {
            $container->getDefinition('silpion_logger_extra.listener.response')->addTag(
              'kernel.event_listener',
              array(
                'event' => 'kernel.response',
                'method' => 'onKernelResponse',
                'priority' => 500
              )
            );
        }
    }
}
