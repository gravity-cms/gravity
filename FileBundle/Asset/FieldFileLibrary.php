<?php

namespace Gravity\FileBundle\Asset;

use Gravity\Component\Asset\AbstractAssetLibrary;

class FieldFileLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return [
            '@GravityFileBundle/field/file.js',
        ];
    }

}
