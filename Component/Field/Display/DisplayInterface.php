<?php

namespace Gravity\Component\Field\Display;

/**
 * Interface DisplayInterface
 *
 * @package Gravity\Component\Field\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface DisplayInterface
{
    /**
     * Get the identifier name of the field widget. This must be a unique name and contain only alphanumeric,
     * underscores (_) and period (.) characters in the format field.widget.<plugin>.<type>
     *
     * @return string
     */
    public function getName();

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get the description of the field widget
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the
     *
     * @return DisplaySettingsInterface
     */
    public function getSettings();
}
