<?php

namespace Gravity\FileBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ImageStyleCompilerPass
 *
 * @package Gravity\FileBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $operations        = $container->findTaggedServiceIds('image_style.operation');
        $imageStyleManager = $container->findDefinition('gravity.image_style_manager');

        $operationServices = [];
        foreach ($operations as $sid => $tags) {
            $reference = new Reference($sid);
            foreach ($tags as $tag) {
                $operationServices[] = $reference;
            }
        }

        $imageStyleManager->addMethodCall('setOperations', [$operationServices]);
    }

} 
