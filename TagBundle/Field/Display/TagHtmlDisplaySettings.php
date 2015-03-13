<?php

namespace Gravity\TagBundle\Field\Display;

use Gravity\TagBundle\Field\Display\Form\TagHtmlDisplaySettingsForm;
use GravityCMS\Component\Configuration\AbstractConfiguration;
use GravityCMS\Component\Field\Display\DisplaySettingsInterface;

/**
 * Class TagHtmlDisplaySettings
 *
 * @package Gravity\TagBundle\Field\Display
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagHtmlDisplaySettings extends AbstractConfiguration implements DisplaySettingsInterface
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
        return 'field.type.tag.display.html.settings';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new TagHtmlDisplaySettingsForm();
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
