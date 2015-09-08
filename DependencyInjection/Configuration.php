<?php

namespace Purjus\SearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
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
                ->scalarNode('min_length')
                    ->defaultValue(3)
                    ->info('The minimum length of a string to be searched.')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
