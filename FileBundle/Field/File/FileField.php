<?php

namespace Gravity\FileBundle\Field\File;

use Gravity\FileBundle\Field\File\Display\FileLink\FileLinkDisplay;
use Gravity\FileBundle\Field\File\Configuration\FileFieldConfiguration;
use Gravity\FileBundle\Field\File\Widget\FileBrowserWidget;
use GravityCMS\Component\Field\AbstractFieldDefinition;
use GravityCMS\Component\Field\Configuration\FieldSettingsConfiguration;
use GravityCMS\Component\Field\Display\DisplayInterface;
use GravityCMS\Component\Field\Widget\WidgetDefinitionInterface;

class FileField extends AbstractFieldDefinition
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'file';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'File';
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
        return new FileLinkDisplay();
    }

    /**
     * @return WidgetDefinitionInterface
     */
    public function getDefaultWidget()
    {
        return new FileBrowserWidget();
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\FileBundle\Entity\FieldFile';
    }

    /**
     * @return FieldSettingsConfiguration
     */
    public function getSettings()
    {
        return new FileFieldConfiguration();
    }

}
