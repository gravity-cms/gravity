<?php

namespace Gravity\Component\Asset;

interface AssetLibraryInterface
{
    /**
     * Return an array of assetic paths to include in this library
     *
     * @return string[]
     */
    public function getStylesheets();

    /**
     * Return an array of assetic paths to include in this library
     *
     * @return string[]
     */
    public function getJavascripts();
}
