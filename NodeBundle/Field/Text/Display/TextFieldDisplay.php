<?php

namespace Gravity\NodeBundle\Field\Text\Display;

use GravityCMS\Component\Field\Display\AbstractDisplay;
use GravityCMS\Component\Field\Display\DisplaySettingsInterface;

/**
 * Class TextFieldDisplay
 *
 * @package Gravity\NodeBundle\Field\Text\Display
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextFieldDisplay extends AbstractDisplay
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.text.display.html';
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
        return new TextFieldDisplaySettings();
    }
}
