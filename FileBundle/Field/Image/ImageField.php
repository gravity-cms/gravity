<?php

namespace Gravity\FileBundle\Field\Image;

use Gravity\FileBundle\Field\Image\Configuration\ImageFieldConfiguration;
use Gravity\FileBundle\Field\Image\Display\Image\ImageDisplay;
use Gravity\FileBundle\Field\Image\Widget\ImageBrowser\ImageBrowserWidget;
use Gravity\Component\Field\AbstractFieldDefinition;
use Gravity\Component\Field\Configuration\FieldSettingsConfiguration;
use Gravity\Component\Field\Display\DisplayInterface;
use Gravity\Component\Field\Widget\WidgetDefinitionInterface;

class ImageField extends AbstractFieldDefinition
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'image';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Image';
    }

    /**
     * Get the description of the field
     *
     * @return string
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * @return DisplayInterface
     */
    public function getDefaultDisplay()
    {
        return new ImageDisplay();
    }

    /**
     * @return WidgetDefinitionInterface
     */
    public function getDefaultWidget()
    {
        return new ImageBrowserWidget();
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\FileBundle\Entity\FieldImage';
    }

    /**
     * @return FieldSettingsConfiguration
     */
    public function getSettings()
    {
        return new ImageFieldConfiguration();
    }

}
