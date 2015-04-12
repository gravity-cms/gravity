<?php


namespace Gravity\FileBundle\Field\Image\Display\Image;

use Gravity\FileBundle\Field\Image\Display\Image\Configuration\ImageDisplayConfiguration;
use GravityCMS\Component\Field\Display\AbstractDisplay;
use GravityCMS\Component\Field\Display\DisplaySettingsInterface;

/**
 * Class ImageDisplay
 *
 * @package Gravity\FileBundle\Field\Image\Display\Image
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageDisplay extends AbstractDisplay
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.image.display.image';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Image';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Display the image';
    }

    /**
     * @return DisplaySettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new ImageDisplayConfiguration();
    }
}
