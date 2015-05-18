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


        $contentTypeRepository = $container->findDefinition('gravity_node.content_type_repository');
        $fieldManager = $container->findDefinition('gravity_cms.field_manager');

        $contentTypesConfig = $container->getParameter('gravity_node.content_types');

        $contentTypeDefinitions = [];
        foreach ($contentTypesConfig as $contentTypeName => $contentTypeConfig) {
            $contentTypeDefinition = $container->register(
                'gravity_node.content_type.' . $contentTypeName,
                "Gravity\\NodeBundle\\Structure\\Model\\ContentType"
            );
            $contentTypeDefinition->setFactory("Gravity\\NodeBundle\\Structure\\Model\\Factory\\ContentTypeFactory::create");
            $contentTypeDefinition->setArguments(
                [
                    new Reference('gravity_cms.field_manager'),
                    $contentTypeName,
                    $contentTypeConfig,
                ]
            );
            $contentTypeDefinition->setPublic(false);
            $contentTypeDefinitions[] = new Reference('gravity_node.content_type.' . $contentTypeName);

            foreach($contentTypeConfig['fields'] as $fieldName => $fieldConfig){
                $fieldManager->addMethodCall('registerField', [
                    $fieldConfig['type'],
                    $fieldName,
                    $fieldConfig['settings'],
                ]);
            }
        }

        $contentTypeRepository->addMethodCall('setContentTypes', [$contentTypeDefinitions]);
    }

} 
