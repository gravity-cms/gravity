<?php

namespace Gravity\TagBundle\Field\Display;

use GravityCMS\Component\Field\Display\AbstractDisplay;
use GravityCMS\Component\Field\Display\DisplaySettingsInterface;

/**
 * Class TagHtmlDisplay
 *
 * @package Gravity\TagBundle\Field\Display
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagHtmlDisplay extends AbstractDisplay
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.tag.display.html';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Full HTML output';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'HTML rendered output';
    }

    /**
     * @return DisplaySettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new TagHtmlDisplaySettings();
    }
}
