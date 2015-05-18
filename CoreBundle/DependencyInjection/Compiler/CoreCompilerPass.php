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
class CoreCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $adminRouterDefinition  = $container->getDefinition('gravity_cms.routing.admin_loader');
        $fieldManagerDefinition = $container->getDefinition('gravity_cms.field_manager');

        $adminRouterDefinition->addMethodCall('setAdminPath',
            [$container->getParameter('gravity_cms.admin_path')]);

        $assetManagerDefinition = $container->getDefinition('assetic.asset_manager');

        $meta = new \ReflectionClass('\Gravity\CoreBundle\GravityCoreBundle');
        $path = pathinfo($meta->getFileName(), PATHINFO_DIRNAME);

        // tell asstic where the plugin assets are
        $assetNamespace = '@core/';
        $folder         = $path . '/Resources/assets/js';
        if (is_dir($folder)) {
            $jsRoot   = '/js';
            $dir      = new \RecursiveDirectoryIterator($folder);
            $ite      = new \RecursiveIteratorIterator($dir);
            $fileList = new \RegexIterator($ite, '/.+\.js/', \RegexIterator::GET_MATCH);

            foreach ($fileList as $files) {
                foreach ($files as $file) {
                    $destination = str_replace($path . '/Resources/assets/js/', '', $file);
                    $assetId     = 'gravity_module_core_' . str_replace(
                            ['/', '.js'],
                            ['_', ''],
                            $destination
                        );
                    $assetPath   = '/cms/core/' . $destination;

                    $assetManagerDefinition->addMethodCall(
                        'setFormula',
                        [
                            $assetId,
                            [
                                $file,
                                ['?uglifyjs2'],
                                [
                                    'output' => $jsRoot . $assetPath
                                ],
                            ]
                        ]
                    );
                }
            }
        }

        $folder = $path . '/Resources/assets/css';
        if (is_dir($folder)) {
            $cssRoot  = '/css';
            $dir      = new \RecursiveDirectoryIterator($folder);
            $ite      = new \RecursiveIteratorIterator($dir);
            $fileList = new \RegexIterator($ite, '/.+\.s?css/', \RegexIterator::GET_MATCH);

            foreach ($fileList as $files) {
                foreach ($files as $file) {
                    $destination = str_replace($path . '/Resources/assets/css/', '', $file);
                    $assetId     = 'gravity_module_core_css_' . str_replace(
                            ['/', '-', '.scss', '.css'],
                            ['_', '_', '', ''],
                            $destination
                        );
                    $assetPath   = '/cms/core/' . $destination;
                    $assetPath   = str_replace('.scss', '.css', $assetPath);

                    $assetManagerDefinition->addMethodCall(
                        'setFormula',
                        [
                            $assetId,
                            [
                                $file,
                                ['compass'],
                                [
                                    'output' => $cssRoot . $assetPath
                                ],
                            ]
                        ]
                    );
                }

                $assetManagerDefinition->addMethodCall(
                    'setFormula',
                    [
                        'gravity_core_css',
                        [
                            $files,
                            ['compass'],
                            []
                        ]
                    ]
                );
            }
        }

        // load in all the fields
        $fields = $container->findTaggedServiceIds('gravity.field');
        foreach ($fields as $sId => $def) {
            $fieldManagerDefinition->addMethodCall('addFieldDefinition', [new Reference($sId)]);
        }

        $fieldWidgets = $container->findTaggedServiceIds('gravity.field.widget');
        foreach ($fieldWidgets as $sId => $def) {
            $fieldManagerDefinition->addMethodCall('addFieldWidget', [new Reference($sId)]);
        }

        $fieldDisplays = $container->findTaggedServiceIds('gravity.field.display');
        foreach ($fieldDisplays as $sId => $def) {
            $fieldManagerDefinition->addMethodCall('addFieldDisplay', [new Reference($sId)]);
        }
    }
} 
