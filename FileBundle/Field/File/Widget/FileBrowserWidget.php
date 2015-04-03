<?php

namespace Gravity\FileBundle\Field\File\Widget;

use Gravity\FileBundle\Asset\FieldFileLibrary;
use Gravity\FileBundle\Field\File\Widget\Configuration\FileBrowserWidgetConfiguration;
use GravityCMS\Component\Field\FieldInterface;
use GravityCMS\Component\Field\Widget\AbstractWidget;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;

class FileBrowserWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.file.widget.file_browser';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'File Browser';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'File Browser';
    }

    /**
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new FileBrowserWidgetConfiguration();
    }

    public function getForm()
    {
        return 'field_file_widget_file_browser';
    }

    public function getEntityClass()
    {
        return 'Gravity\FileBundle\Entity\FieldFile';
    }

    public function getAssetLibraries()
    {
        return [
            new FieldFileLibrary(),
        ];
    }

    /**
     * Checks if this widget supports the given field
     *
     * @param FieldInterface $field
     *
     * @return string
     */
    public function supportsField(FieldInterface $field)
    {
        return ($field->getName() === 'file');
    }

}
