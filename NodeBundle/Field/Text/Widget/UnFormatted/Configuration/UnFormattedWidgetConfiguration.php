<?php

namespace Gravity\NodeBundle\Field\Text\Widget\UnFormatted\Configuration;

use GravityCMS\Component\Configuration\AbstractConfiguration;
use GravityCMS\Component\Field\Widget\AbstractWidgetConfiguration;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;

/**
 * Class UnFormattedWidgetConfiguration
 *
 * @package Gravity\NodeBundle\Field\Text\Widget\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class UnFormattedWidgetConfiguration extends AbstractWidgetConfiguration
{
    /**
     * @var bool
     */
    protected $multiLine = false;

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
        return new UnFormattedWidgetConfigurationForm();
    }

    /**
     * @return boolean
     */
    public function isMultiLine()
    {
        return $this->multiLine;
    }

    /**
     * @param boolean $multiLine
     */
    public function setMultiLine($multiLine)
    {
        $this->multiLine = $multiLine;
    }
}
