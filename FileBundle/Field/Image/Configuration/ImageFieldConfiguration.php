<?php


namespace Gravity\FileBundle\Field\Image\Configuration;

use Gravity\Component\Field\Configuration\FieldSettingsConfiguration;

/**
 * Class ImageFieldConfiguration
 *
 * @package Gravity\FileBundle\Field\Image\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageFieldConfiguration extends FieldSettingsConfiguration
{
    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType()
    {
        return 'field.image';
    }

    /**
     * The form name or object
     *
     * @return string|object
     */
    public function getForm()
    {
        return new ImageFieldConfigurationForm();
    }

}
