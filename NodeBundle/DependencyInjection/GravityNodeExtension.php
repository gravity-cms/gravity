<?php

namespace Gravity\NodeBundle\DependencyInjection;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GravityNodeExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        // get the content_types definition
        $contentTypesConfig    = $config['content_types'];
        $contentTypeRepository = $container->findDefinition('gravity_node.content_type_repository');

        // TODO: put this in a compiler pass
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
        }

        $contentTypeRepository->addMethodCall('setContentTypes', [$contentTypeDefinitions]);
    }
}
