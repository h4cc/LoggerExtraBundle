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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration for Bundle.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('silpion_logger_extra');

        $rootNode
          ->children()
          ->booleanNode('request_id')
          ->defaultFalse()
          ->info('If a random request_id should be added to the [extra] section of each log message.')
          ->end()
          ->booleanNode('session_id')
          ->defaultFalse()
          ->info('If a salted SHA1 of the session_id should be added to the [extra] section of each log message.')
          ->end()
          ->arrayNode('additions')
          ->info(
            'A list of "key: value" entries that will be set in the [extra] section of each log message (Overwrites existing keys!).'
          )
          ->useAttributeAsKey('key')
          ->prototype('scalar')
          ->info('Value for the key.')
          ->isRequired()
          ->example('value')
          ->end()
          ->end()
          ->end();

        return $treeBuilder;
    }
}
