<?php

namespace Gravity\CoreBundle\DependencyInjection;

use Gravity\Component\Module\Compiler\ModuleCompiler;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GravityCoreExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        // read in the gravity bundles
        $gravityConfig = $container->getParameter('kernel.root_dir') . '/config/gravity/bundles.yml';

        $yamlParser        = new Yaml();
        $gravityConfigYaml = file_get_contents($gravityConfig);
        $gravityConfig     = $yamlParser->parse($gravityConfigYaml);
        $container->setParameter('gravity.bundles', $gravityConfig['bundles']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('gravity_cms.admin_path', $config['cms']['admin_path']);

        $container->setParameter("gravity_cms.entity_manager", $config['entity_manager']);
        $container->setParameter("gravity_cms.backend_type_orm", $config['backend_type'] === 'orm');
        $container->setParameter("gravity_cms.default_editor", $config['default_editor']);
    }
}
