<?php

namespace Purjus\SearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('purjus_search');

        $rootNode
            ->children()
                ->integerNode('min_length')
                    ->defaultValue(3)
                    ->min(1)
                    ->info('The minimum length of a string to be searched.')
                ->end()
            ->end()
            ->children()
                ->integerNode('max_entries')
                    ->defaultValue(5)
                    ->min(1)
                    ->info('The maximum of an Entry by Group.')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
