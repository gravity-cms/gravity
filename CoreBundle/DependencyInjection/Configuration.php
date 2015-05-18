<?php

namespace Gravity\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gravity_core');

        $rootNode->isRequired()
            ->children()
            ->scalarNode('entity_manager')->isRequired()->end()
            ->scalarNode('backend_type')->isRequired()->end()
            ->scalarNode('default_editor')->isRequired()->end()
            ->end();

        $this->addCMSSection($rootNode);

        return $treeBuilder;
    }

    private function addCMSSection(NodeDefinition $rootNode)
    {
        $rootNode->children()
            ->arrayNode('cms')
            ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('admin_path')->defaultValue('/admin/cms')->isRequired()
                ->end()
            ->end()
        ->end();
    }
}
