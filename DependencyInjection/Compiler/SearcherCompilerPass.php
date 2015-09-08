<?php

namespace Purjus\SearchBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * CompilerPass for searchers.
 * It adds all the searcher services tagged 'purjus_search.searcher'
 * and add them to the @see SearchManager
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SearcherCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {

        if (false === $container->hasDefinition('purjus_search.manager')) {
            return;
        }

        $definition = $container->getDefinition('purjus_search.manager');

        $taggedServices = $container->findTaggedServiceIds('purjus_search.searcher');


        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('addSearcher', array(new Reference($id)));
        }
    }
}