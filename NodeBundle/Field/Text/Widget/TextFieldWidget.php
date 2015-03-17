<?php

namespace Gravity\NodeBundle\Field\Text\Widget;

use GravityCMS\Component\Field\FieldInterface;
use GravityCMS\Component\Field\Widget\AbstractWidget;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;
use Gravity\NodeBundle\Field\Text\Asset\TextFieldWidgetLibrary;
use Gravity\NodeBundle\Field\Text\Widget\Form\TextFieldWidgetForm;

/**
 * Class TextFieldWidget
 *
 * @package Gravity\NodeBundle\Field\Text\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextFieldWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.text.widget.editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Text Editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'WYSIWYG editor for text field';
    }

    /**
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new TextFieldWidgetSettings();
    }

    public function getForm()
    {
        return new TextFieldWidgetForm();
    }

    public function getEntityClass()
    {
        return 'Gravity\NodeBundle\Entity\FieldText';
    }

    public function getAssetLibraries()
    {
        return array(
            new TextFieldWidgetLibrary(),
        );
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
        return ($field->getName() === 'text');
    }

}
