<?php

namespace Gravity\Component\Asset;

/**
 * Class AbstractAssetLibrary
 *
 * @package Gravity\Component\Asset
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractAssetLibrary implements AssetLibraryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getStylesheets()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getJavascripts()
    {
        return [];
    }
}
