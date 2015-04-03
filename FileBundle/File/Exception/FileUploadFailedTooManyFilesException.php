<?php

namespace Gravity\FileBundle\File\Exception;

/**
 * Class FileUploadFailedTooManyFilesException
 *
 * @package Gravity\FileBundle\File\Exception
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileUploadFailedTooManyFilesException extends FileUploadException
{
    public function __construct(\Exception $previous = null)
    {
        parent::__construct("Too many files were given, allowed only 1.", null, $previous);
    }
}
