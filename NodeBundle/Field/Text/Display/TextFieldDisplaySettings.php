<?php

namespace Gravity\NodeBundle\Field\Text\Display;

use GravityCMS\Component\Configuration\AbstractConfiguration;
use GravityCMS\Component\Field\Display\DisplaySettingsInterface;
use Gravity\NodeBundle\Field\Text\Display\Form\TextFieldDisplaySettingsForm;

/**
 * Class DisplayBodySettings
 *
 * @package Gravity\NodeBundle\Field\Text\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextFieldDisplaySettings extends AbstractConfiguration implements DisplaySettingsInterface
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
        return 'field.type.text.display.html.settings';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new TextFieldDisplaySettingsForm();
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
