<?php

namespace Gravity\NodeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class NodeCompilerPass
 *
 * @package Gravity\NodeBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $pathProcessorManager = $container->findDefinition('gravity_node.node_route_manager');
        $pathProcessors = $container->findTaggedServiceIds('gravity_node.node.path_processor');

        foreach($pathProcessors as $sid => $args){
            $pathProcessorManager->addMethodCall('addPathProcessor', array(new Reference($sid)));
        }
    }

} 
