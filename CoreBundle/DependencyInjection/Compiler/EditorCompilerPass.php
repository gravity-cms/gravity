<?php

namespace Gravity\CoreBundle\DependencyInjection\Compiler;

use Nefarian\CmsBundle\Plugin\PluginCompiler;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class EditorCompilerPass
 *
 * @package Gravity\CoreBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class EditorCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $editorManagerDefinition = $container->findDefinition('gravity.editor_manager');
        $editorServices = $container->findTaggedServiceIds('gravity.editor');

        $defaultEditor = 'gravity.editor.' . $container->getParameter('gravity_cms.default_editor');

        foreach($editorServices as $editorServiceId=>$props)
        {
            $editorDefinition = $container->getDefinition($editorServiceId);
            $editorManagerDefinition->addMethodCall('addEditor', array($editorDefinition));

            if($editorServiceId == $defaultEditor)
            {
                $container->setAlias('gravity.editor', $editorServiceId);
            }
        }

    }


} 
