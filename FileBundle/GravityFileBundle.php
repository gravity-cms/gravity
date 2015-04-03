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

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new Compilers\FileCompilerPass());
        $container->addCompilerPass(new Compilers\StreamWrapperCompilerPass());
    }
}
