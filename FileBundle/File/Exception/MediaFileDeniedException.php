<?php

namespace Gravity\FileBundle\File\Exception;

/**
 * Class FileFileDeniedException
 *
 * @package Gravity\FileBundle\File\Exception
 */
class FileFileDeniedException extends \Exception
{
    /**
     * @param string $fileType
     */
    function __construct($fileType)
    {
        parent::__construct("This file type is not allowed: {$fileType}");
    }
}
