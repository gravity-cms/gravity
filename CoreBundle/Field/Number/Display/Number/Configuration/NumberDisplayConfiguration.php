<?php


namespace Gravity\CoreBundle\Field\Number\Display\Number\Configuration;

use Gravity\Component\Configuration\AbstractConfiguration;
use Gravity\Component\Field\Display\DisplaySettingsInterface;

/**
 * Class NumberDisplayConfiguration
 *
 * @package Gravity\CoreBundle\Field\Number\Display\Number\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class NumberDisplayConfiguration extends AbstractConfiguration implements DisplaySettingsInterface
{
    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType()
    {
        return 'field.type.number.display.number';
    }

    /**
     * The form name or object
     *
     * @return string|object
     */
    public function getForm()
    {
        return new NumberDisplayConfigurationForm();
    }

}
