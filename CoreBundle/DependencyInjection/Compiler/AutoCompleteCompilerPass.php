<?php

namespace Gravity\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AutoCompleteCompilerPass
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class AutoCompleteCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $autoCompleteManagerDefinition  = $container->getDefinition('gravity.cms.auto_complete_manager');

        $handlers = $container->findTaggedServiceIds('auto_complete.handler');

        foreach($handlers as $sid => $opts)
        {
            $autoCompleteManagerDefinition->addMethodCall('addHandler', array(new Reference($sid)));
        }

    }
} 
