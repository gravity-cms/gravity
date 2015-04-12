<?php


namespace Gravity\FileBundle\Field\Image\Widget\ImageBrowser\Configuration;

use GravityCMS\Component\Configuration\AbstractConfiguration;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;

/**
 * Class ImageBrowserWidgetConfiguration
 *
 * @package Gravity\FileBundle\Field\Image\Widget\ImageBrowser\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageBrowserWidgetConfiguration extends AbstractConfiguration implements WidgetSettingsInterface
{
    /**
     * @var string
     */
    protected $imageStyle;

    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType()
    {
        return 'field.image.widget.image_browser';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new ImageBrowserWidgetConfigurationForm();
    }

    /**
     * @return string
     */
    public function getImageStyle()
    {
        return $this->imageStyle;
    }

    /**
     * @param string $imageStyle
     */
    public function setImageStyle($imageStyle)
    {
        $this->imageStyle = $imageStyle;
    }
}
