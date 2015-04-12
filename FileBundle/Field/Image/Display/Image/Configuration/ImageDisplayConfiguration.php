<?php


namespace Gravity\FileBundle\Field\Image\Display\Image\Configuration;

use GravityCMS\Component\Configuration\AbstractConfiguration;
use GravityCMS\Component\Field\Display\DisplaySettingsInterface;

/**
 * Class ImageDisplayConfiguration
 *
 * @package Gravity\FileBundle\Field\Image\Display\Image\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageDisplayConfiguration extends AbstractConfiguration implements DisplaySettingsInterface
{
    /**
     * @var bool
     */
    protected $useEditor = true;

    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType()
    {
        return 'field.image.display.image';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new ImageDisplayConfigurationForm();
    }

    /**
     * @return boolean
     */
    public function getUseEditor()
    {
        return $this->useEditor;
    }

    /**
     * @param boolean $useEditor
     */
    public function setUseEditor($useEditor)
    {
        $this->useEditor = $useEditor;
    }
}
