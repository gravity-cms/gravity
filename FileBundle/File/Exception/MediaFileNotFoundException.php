<?php

namespace Gravity\FileBundle\File\Exception;

use Gravity\FileBundle\Model\File;

/**
 * Class FileFileNotFoundException
 *
 * @package Gravity\FileBundle\File\Exception
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileFileNotFoundException extends \Exception
{
    /**
     * @param string     $path
     * @param \Exception $e
     */
    function __construct($path, \Exception $e = null)
    {
        parent::__construct("This file file not found: {$path}", null, $e);
    }
}
