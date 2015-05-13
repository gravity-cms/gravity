<?php

namespace Gravity\TagBundle\Field\Widget\AutoComplete\Configuration;

use GravityCMS\Component\Field\Widget\AbstractWidgetConfiguration;

/**
 * Class TagAutoCompleteWidgetSettings
 *
 * @package Gravity\TagBundle\Field\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagAutoCompleteWidgetConfiguration extends AbstractWidgetConfiguration
{
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
        return new TagAutoCompleteWidgetConfigurationForm();
    }
}
