<?php

namespace Gravity\CoreBundle\Field\Text\Widget\Formatted;

use Gravity\Component\Field\FieldDefinitionInterface;
use Gravity\Component\Field\Widget\AbstractWidgetDefinition;
use Gravity\CoreBundle\Entity\FieldText;
use Gravity\CoreBundle\Field\Text\Widget\Formatted\Asset\FormattedWidgetLibrary;

/**
 * Class FormattedWidget
 *
 * @package Gravity\CoreBundle\Field\Text\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FormattedWidget extends AbstractWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text.formatted';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Formatted Text Editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'WYSIWYG editor for formatted text';
    }

    public function getForm()
    {
        return new FormattedWidgetForm();
    }

    public function getEntityClass()
    {
        return 'Gravity\CoreBundle\Entity\FieldText';
    }

    public function getAssetLibraries()
    {
        return [
            new FormattedWidgetLibrary(),
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
        return ($field->getName() === 'text');
    }
}
