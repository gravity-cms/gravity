<?php

namespace Gravity\FileBundle\Asset;

use Gravity\Component\Asset\AbstractAssetLibrary;

class FieldImageLibrary extends AbstractAssetLibrary
{
    /**
     * {@inheritdoc}
     */
    public function getJavascripts()
    {
        return [
            '@GravityFileBundle/field/image.js',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getStylesheets()
    {
        return [
            '@GravityFileBundle/sass/fields/image.scss',
        ];
    }
}
