<?php

namespace Gravity\FileBundle;

use Gravity\FileBundle\DependencyInjection\Compiler as Compilers;
use GravityCMS\Component\Bundle\GravityBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GravityFileBundle extends GravityBundle
{
    /**
     * @return string
     */
    public function getGravityBundleName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new Compilers\FileCompilerPass());
        $container->addCompilerPass(new Compilers\StreamWrapperCompilerPass());
        $container->addCompilerPass(new Compilers\ImageStyleCompilerPass());
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $streamWrapperManager = $this->container->get('gravity.stream_wrapper_manager');
        $streamWrapperManager->register();
    }
}
