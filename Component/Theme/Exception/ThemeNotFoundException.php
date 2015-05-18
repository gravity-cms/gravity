<?php

namespace Gravity\Component\Theme\Exception;

use Exception;

class ThemeNotFoundException extends \Exception
{
    public function __construct($theme, $code = 0, Exception $previous = null)
    {
        parent::__construct("Theme \"{$theme}\" not found", $code, $previous);
    }
} 
