<?php

namespace Gravity\CoreBundle\DependencyInjection\Compiler\Exception;

use Exception;

/**
 * Class InvalidGravityBundleException
 *
 * @package Gravity\CoreBundle\DependencyInjection\Compiler\Exception
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class InvalidGravityBundleException extends \Exception
{
    public function __construct($object, Exception $previous = null)
    {
        $objectClass = get_class($object);
        $message = "Bundle '{$objectClass}' must be an instance of \\Gravity\\Component\\Bundle\\GravityBundle";
        parent::__construct($message, null, $previous);
    }

}
