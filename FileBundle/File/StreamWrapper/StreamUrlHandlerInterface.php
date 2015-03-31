<?php

namespace Gravity\FileBundle\File\StreamWrapper;

/**
 * Interface StreamUrlHandlerInterface
 *
 * @package Gravity\FileBundle\File\StreamWrapper\UrlHandler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface StreamUrlHandlerInterface
{
    /**
     * Convert the path into a public URL that can be rendered.
     *
     * @param string $path
     *
     * @return string
     */
    public function handle($path);
}
