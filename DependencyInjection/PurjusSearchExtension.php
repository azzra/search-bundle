<?php

namespace Purjus\SearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Purjus Search Extension
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class PurjusSearchExtension extends Extension
{

    /**
     * {@inheritdoc}
     *
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('purjus_search.min_length', $config['min_length']);
        $container->setParameter('purjus_search.max_entries', $config['max_entries']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
