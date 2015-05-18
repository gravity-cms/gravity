<?php


namespace Gravity\Component\Tests\Asset;

use Gravity\Component\Asset\AbstractAssetLibrary;

/**
 * Class Test
 *
 * @package Gravity\Component\Tests\Asset
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class AssetLibraryTest extends \PHPUnit_Framework_TestCase
{
    public function testAssetLibrary()
    {
        /** @var AbstractAssetLibrary $assetLibrary */
        $assetLibrary = $this->getMockBuilder('\Gravity\Component\Asset\AbstractAssetLibrary')
            ->setMethods(null)
            ->getMock();

        $javascripts = $assetLibrary->getJavascripts();

        $this->assertTrue(is_array($javascripts));
        $this->assertEquals([], $javascripts);

        $stylesheets = $assetLibrary->getStylesheets();
        $this->assertTrue(is_array($stylesheets));
        $this->assertEquals([], $stylesheets);
    }
}
