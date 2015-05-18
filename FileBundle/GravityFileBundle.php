<?php

namespace Gravity\FileBundle;

use Gravity\FileBundle\DependencyInjection\Compiler as Compilers;
use Gravity\Component\Bundle\GravityBundle;
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

    }
}
