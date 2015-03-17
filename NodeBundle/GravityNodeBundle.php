<?php

namespace Gravity\NodeBundle;

use GravityCMS\Component\Bundle\GravityBundle;
use Gravity\NodeBundle\DependencyInjection\Compiler as Compilers;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GravityNodeBundle extends GravityBundle
{
    /**
     * @return string
     */
    public function getGravityBundleName()
    {
        return 'node';
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Compilers\NodeCompilerPass());
    }
}
