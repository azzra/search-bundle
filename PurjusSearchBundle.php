<?php

namespace Purjus\SearchBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Purjus\SearchBundle\DependencyInjection\Compiler\SearcherCompilerPass;


/**
 * Simple wide site search base on event system.
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class PurjusSearchBundle extends Bundle
{

    /**
     * {@inheritdoc}
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new SearcherCompilerPass());
    }

}
