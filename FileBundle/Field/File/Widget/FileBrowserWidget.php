<?php

namespace Gravity\FileBundle\Field\File\Widget;

use Gravity\FileBundle\Asset\FieldFileLibrary;
use Gravity\FileBundle\Field\File\Widget\Configuration\FileBrowserWidgetConfiguration;
use Gravity\Component\Field\FieldDefinitionInterface;
use Gravity\Component\Field\Widget\AbstractWidgetDefinition;

class FileBrowserWidget extends AbstractWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'file.file_browser';
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
     * @param FieldDefinitionInterface $field
     *
     * @return string
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return ($field->getName() === 'file');
    }

}
