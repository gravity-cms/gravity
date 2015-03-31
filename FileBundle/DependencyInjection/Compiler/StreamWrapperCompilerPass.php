<?php

namespace Gravity\FileBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class StreamWrapperCompilerPass
 *
 * @package Gravity\FileBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class StreamWrapperCompilerPass implements CompilerPassInterface
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
        $taggedFileProviders  = $container->findTaggedServiceIds('gravity.stream_wrapper');
        $streamWrapperManager = $container->findDefinition('gravity.stream_wrapper_manager');

        foreach ($taggedFileProviders as $sid => $tags) {
            foreach ($tags as $tag) {
                $streamWrapperManager->addMethodCall('addStreamWrapper', [new Reference($sid)]);
            }
        }
    }

} 
