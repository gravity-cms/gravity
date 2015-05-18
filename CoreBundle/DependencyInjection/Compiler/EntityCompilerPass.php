<?php

namespace Gravity\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CoreCompilerPass
 *
 * @package Gravity\CoreBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class EntityCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $gravityEntityManagerDefinition  = $container->getDefinition('gravity_cms.entity_manager');

        $entityDefinitionTaggedServices = $container->findTaggedServiceIds('gravity.entity');
        $entityDefinitions = array();
        foreach ($entityDefinitionTaggedServices as $sId => $tags) {
            $serviceReference = new Reference($sId);
            foreach($tags as $tag)
            {
                $entityDefinitions[] = $serviceReference;
            }
        }

        $gravityEntityManagerDefinition->addMethodCall('setEntityDefinitions', array($entityDefinitions));

    }
} 
