<?php

namespace Gravity\FileBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FileCompilerPass
 *
 * @package Gravity\FileBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileCompilerPass implements CompilerPassInterface
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
        $taggedFileProviders = $container->findTaggedServiceIds('gravity.file.provider');
        $fileManager = $container->findDefinition('gravity.file_manager');
//        $fileManager->addMethodCall('setDefaultProvider', ['local_storage']);

        foreach($taggedFileProviders as $sid => $params){
            $fileManager->addMethodCall('addFileProvider', [new Reference($sid)]);
            if(isset($params[0]['default']) && $params[0]['default'] == true){
            }
        }
    }

} 
