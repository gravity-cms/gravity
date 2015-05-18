<?php

namespace Gravity\CoreBundle\DependencyInjection\Compiler;

use Gravity\Component\Menu\DependencyInjection\Configuration\MenuConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 * Class MenuCompilerPass
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class MenuCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $menuManagerDefinition  = $container->getDefinition('gravity_cms.menu_manager');

        $bundleMeta = new \ReflectionClass('\Gravity\CoreBundle\GravityCoreBundle');
        $bundleDirectory = pathinfo($bundleMeta->getFileName(), PATHINFO_DIRNAME);

        $parser    = new Parser();
        $processor = new Processor();
        $configuration = new MenuConfiguration();
        $menus = $processor->processConfiguration(
            $configuration,
            array(
                $parser->parse(file_get_contents($bundleDirectory . '/Resources/config/menu.yml'))
            )
        );

        foreach ($menus as $menuName => $menu) {

            $menuManagerDefinition->addMethodCall(
                'createCategory',
                array(
                    $menuName,
                    null,
                    $menu['title'],
                    $menu['icon'],
                    $menu['description'],
                    $menu['items'],
                )
            );
        }
    }
} 
