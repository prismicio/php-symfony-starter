<?php

namespace Prismic\PrismicStarterProjectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('prismic');

        $rootNode
            ->children()
                ->scalarNode('endpoint')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('accessToken')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('clientId')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('clientSecret')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
