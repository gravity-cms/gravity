<?php

namespace Gravity\FileBundle\Field\File\Display\FileLink\Configuration;

use Gravity\TagBundle\Field\Display\Form\TagHtmlDisplaySettingsForm;
use GravityCMS\Component\Configuration\AbstractConfiguration;
use GravityCMS\Component\Field\Display\DisplaySettingsInterface;

/**
 * Class FileLinkDisplayConfiguration
 *
 * @package Gravity\FileBundle\Field\File\Display\FileLink\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileLinkDisplayConfiguration extends AbstractConfiguration implements DisplaySettingsInterface
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
        return 'field.tag.display.file_link';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new FileLinkDisplayConfigurationForm();
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
