<?php

namespace Gravity\CoreBundle\DependencyInjection\Compiler;

use Gravity\Component\Bundle\GravityBundle;
use Gravity\CoreBundle\DependencyInjection\Compiler\Exception\InvalidGravityBundleException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class BundleCompilerPass
 *
 * @package Gravity\CoreBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class BundleCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('gravity.bundles');

        $menuManagerDefinition         = $container->getDefinition('gravity_cms.menu_manager');
        $assetManagerDefinition        = $container->getDefinition('assetic.asset_manager');
        $gravityAssetManagerDefinition = $container->getDefinition('gravity_cms.asset_manager');

        $cssFiles = [];
        $assetMap = [];

        foreach ($bundles as $bundleClass) {

            /** @var GravityBundle $bundle */
            $bundle = new $bundleClass();

            if (!$bundle instanceof GravityBundle) {
                throw new InvalidGravityBundleException($bundle);
            }

            // build an array of all assets, then inject the maps into the asset controller
            $assetNamespace = '@' . $bundle->getName() . '/';

            // tell asstic where the module assets are
            $folder = $bundle->getPath() . '/Resources/assets/js';
            if (is_dir($folder)) {
                $jsRoot   = '/js';
                $dir      = new \RecursiveDirectoryIterator($folder);
                $ite      = new \RecursiveIteratorIterator($dir);
                $fileList = new \RegexIterator($ite, '/.+\.js/', \RegexIterator::GET_MATCH);

                foreach ($fileList as $files) {
                    foreach ($files as $file) {
                        $destination = str_replace($bundle->getPath() . '/Resources/assets/js/', '', $file);
                        $assetId     = 'gravity_module_' . $bundle->getGravityBundleName() . '_' . str_replace(
                                ['/', '-', '.js'],
                                ['_', '_', ''],
                                $destination
                            );
                        $assetPath   = '/cms/' . $bundle->getGravityBundleName() . '/' . $destination;

                        $assetMap[$assetNamespace . $destination] = $assetPath;

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


            $folder = $bundle->getPath() . '/Resources/assets/sass';
            if (is_dir($folder)) {
                $cssRoot  = '/css';
                $dir      = new \RecursiveDirectoryIterator($folder);
                $ite      = new \RecursiveIteratorIterator($dir);
                $fileList = new \RegexIterator($ite, '/.+\.s?css/', \RegexIterator::GET_MATCH);

                foreach ($fileList as $files) {
                    foreach ($files as $file) {
                        // skip _*.scss files
                        if(strpos($file, '_') === 0){
                            continue;
                        }
                        $destination = str_replace($bundle->getPath() . '/Resources/assets/sass', 'css', $file);
                        $assetId     = 'gravity_module_' . $bundle->getGravityBundleName() . '_' . str_replace(
                                ['/', '-', '.scss', '.css'],
                                ['_', '_', '', ''],
                                $destination
                            );
                        $assetPath   = '/cms/' . $bundle->getGravityBundleName() . '/' . $destination;
                        $assetPath   = str_replace('.scss', '.css', $assetPath);

                        $assetMap[$assetNamespace . $destination] = $assetPath;
                        $cssFiles[]                               = $file;

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
                }
            }

            $folder = $bundle->getPath() . '/Resources/assets/img';
            if (is_dir($folder)) {
                $imgRoot = '/img';
                $maps    = [
                    '.jpg'  => 'jpegoptim',
                    '.jpeg' => 'jpegoptim',
                    '.png'  => 'optipng',
                    '.gif'  => null,
                ];
                foreach ($maps as $ext => $app) {
                    if ($app) {
                        $app = ['?' . $app];
                    } else {
                        $app = [];
                    }

                    $dir      = new \RecursiveDirectoryIterator($folder);
                    $ite      = new \RecursiveIteratorIterator($dir);
                    $fileList = new \RegexIterator($ite, '/.+\.' . $ext . '/', \RegexIterator::GET_MATCH);

                    foreach ($fileList as $files) {
                        foreach ($files as $file) {
                            $destination = str_replace($bundle->getPath() . '/Resources/assets/img/', '', $file);
                            $assetPath   = '/theme/' . $bundle->getGravityBundleName() . '/' . $destination;

                            $assetMap[$assetNamespace . $destination] = $assetPath;

                            $assetManagerDefinition->addMethodCall(
                                'setFormula',
                                [
                                    'gravity_module_' . $bundle->getGravityBundleName() . '_' . str_replace(
                                        ['/', $ext],
                                        ['_', ''],
                                        $destination
                                    ),
                                    [
                                        $file,
                                        $app,
                                        [
                                            'output' => $imgRoot . $assetPath
                                        ],
                                    ]
                                ]
                            );
                        }
                    }
                }
            }

            // TODO: Finish loading module menu
            if (file_exists($menuConfigFile = $bundle->getPath() . '/Resources/config/menu.yml')) {
                $menuConfig = Yaml::parse(file_get_contents($menuConfigFile));
                foreach ($menuConfig as $menuName => $menu) {
                    $menu += [
                        'icon'        => '',
                        'description' => ''
                    ];

                    $menuManagerDefinition->addMethodCall(
                        'createCategory',
                        [
                            $menuName,
                            null,
                            $menu['title'],
                            $menu['icon'],
                            $menu['description'],
                            $menu['items'],
                        ]
                    );
                }
            }

            // add the assetmap to the asset manager
            $gravityAssetManagerDefinition->addMethodCall('addAssetMap', [$assetMap]);

            /**
             * @TODO: dump cached
             * @see http://symfony.com/doc/current/components/dependency_injection/compilation.html#dumping-the-configuration-for-performance
             */
        }

        $assetManagerDefinition->addMethodCall(
            'setFormula',
            [
                'gravity_bundle_css',
                [
                    $cssFiles,
                    ['compass'],
                    []
                ]
            ]
        );
    }
} 
