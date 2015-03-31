<?php

namespace Gravity\FileBundle\File\StreamWrapper\Local;

use Symfony\Component\Routing\Generator\UrlGenerator;

class PublicStreamWrapper extends LocalStreamWrapper
{
    public $uri;
    public $handle;

    /**
     * @var string
     */
    static $absolutePath;
    static $relativePath;

    /**
     * @var UrlGenerator
     */
    static $urlGenerator;

    /**
     * Get the stream scheme name
     *
     * @return string
     */
    public function getScheme()
    {
        return 'public';
    }

    /**
     * Gravity StreamWrapper Name
     *
     * @return string
     */
    public function getName()
    {
        return 'Public Local File System';
    }

    /**
     * Gravity StreamWrapper Description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Files are stored on a local, public folder under your site\'s web route';
    }

    public function getExternalUrl()
    {
        return self::$relativePath . '/' . $this->getTarget();
    }

    public function setDirPaths($absolutePath, $relativePath)
    {
        if(!is_dir($absolutePath)){
            mkdir($absolutePath, 0644, true);
        }
        self::$absolutePath = realpath($absolutePath);
        self::$relativePath = rtrim($relativePath, '/');
    }

    public function getDirectoryPath()
    {
        return self::$absolutePath;
    }
}
