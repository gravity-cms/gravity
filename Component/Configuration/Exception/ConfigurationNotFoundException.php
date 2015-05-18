<?php

namespace Gravity\Component\Configuration\Exception;

/**
 * Class ConfigurationNotFoundException
 *
 * @package Gravity\Component\Configuration\Exception
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigurationNotFoundException extends \Exception
{
    public function __construct($name, \Exception $previous = null)
    {
        $message = sprintf("Configuration \"%s\" not found", $name);
        parent::__construct($message, null, $previous);
    }
}
