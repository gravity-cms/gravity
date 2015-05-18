<?php

namespace Gravity\TagBundle;

use Gravity\NodeBundle\DependencyInjection\Compiler as Compilers;
use GravityCMS\Component\Bundle\GravityBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GravityTagBundle extends GravityBundle
{
    /**
     * @return string
     */
    public function getGravityBundleName()
    {
        return 'tag';
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new Compilers\NodeCompilerPass());
    }

}
