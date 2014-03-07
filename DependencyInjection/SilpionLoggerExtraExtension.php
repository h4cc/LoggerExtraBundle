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

        // Activate adding if request_id if enabled.
        if ($config['request_id']) {
            $definition = $container->getDefinition('silpion_logger_extra.logger.processor.request_id');
            $definition->addTag('monolog.processor', array('method' => 'processRecord'));
        }

        // Activate adding if session_id if enabled.
        if ($config['session_id']) {
            $definition = $container->getDefinition('silpion_logger_extra.logger.processor.session_id');
            $definition->addTag('monolog.processor', array('method' => 'processRecord'));
        }

        // Add additions if any defined.
        if ($config['additions']) {
            $definition = $container->getDefinition('silpion_logger_extra.logger.processor.additions');
            $definition->addTag('monolog.processor', array('method' => 'processRecord'));
            $definition->replaceArgument(0, $config['additions']);
        }
    }
}
