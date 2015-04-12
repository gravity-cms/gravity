<?php

namespace Gravity\FileBundle\Asset;

use GravityCMS\Component\Asset\AbstractAssetLibrary;

class FieldImageLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return [
            '@GravityFileBundle/field/image.js',
        ];
    }

}
