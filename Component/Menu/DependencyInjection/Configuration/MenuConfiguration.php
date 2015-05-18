<?php

namespace Gravity\Component\Menu\DependencyInjection\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class MenuConfiguration
 *
 * @package Gravity\Component\Menu\DependencyInjection\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class MenuConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('menu');

        $rootNode
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('title')->isRequired()->end()
                    ->scalarNode('description')->defaultValue('')->end()
                    ->scalarNode('icon')->isRequired()->end()
                    ->arrayNode('items')
                        ->prototype('array')
                        ->children()
                            ->scalarNode('title')->isRequired()->end()
                            ->scalarNode('route')->isRequired()->end()
                            ->scalarNode('description')->end()
                        ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
} 
