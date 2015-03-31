<?php

namespace Gravity\FileBundle\Field\File\Display\FileLink;

use Gravity\FileBundle\Field\File\Display\FileLink\Configuration\FileLinkDisplayConfiguration;
use GravityCMS\Component\Field\Display\AbstractDisplay;
use GravityCMS\Component\Field\Display\DisplaySettingsInterface;

/**
 * Class FileLinkDisplay
 *
 * @package Gravity\FileBundle\Field\File\Display\FileLink
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileLinkDisplay extends AbstractDisplay
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.file.display.file_link';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'File Links';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Display formatted links for each file';
    }

    /**
     * @return DisplaySettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new FileLinkDisplayConfiguration();
    }
}
