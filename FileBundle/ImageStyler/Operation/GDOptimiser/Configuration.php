<?php


namespace Gravity\FileBundle\ImageStyler\Operation\GDOptimiser;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Gravity\FileBundle\ImageStyler\Operation\GDOptimiser\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gd_optimiser');

        $rootNode
            ->children()
                ->scalarNode('quality')->defaultValue(75)->isRequired()->end()
            ->end();

        return $treeBuilder;
    }

}
