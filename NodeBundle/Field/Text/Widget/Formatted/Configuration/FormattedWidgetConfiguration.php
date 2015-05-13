<?php

namespace Gravity\NodeBundle\Field\Text\Widget\Formatted\Configuration;

use GravityCMS\Component\Field\Widget\AbstractWidgetConfiguration;

/**
 * Class FormattedWidgetConfiguration
 *
 * @package Gravity\NodeBundle\Field\Text\Widget\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FormattedWidgetConfiguration extends AbstractWidgetConfiguration
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
        return new FormattedWidgetConfigurationForm();
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
