<?php

namespace Gravity\NodeBundle\Field\Text\Widget;

use GravityCMS\Component\Configuration\AbstractConfiguration;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;
use Gravity\NodeBundle\Field\Text\Widget\Form\TextFieldWidgetSettingsForm;

/**
 * Class WidgetBodySettings
 *
 * @package Gravity\NodeBundle\Field\Text\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextFieldWidgetSettings extends AbstractConfiguration implements WidgetSettingsInterface
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
        return 'field.type.text.widget.editor.settings';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new TextFieldWidgetSettingsForm();
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
