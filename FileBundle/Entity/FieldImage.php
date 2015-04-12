<?php

namespace Gravity\FileBundle\Entity;

use GravityCMS\CoreBundle\Entity\FieldData;

/**
 * Class FieldImage
 *
 * @package Gravity\FileBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldImage extends FieldData
{
    /**
     * @var File[]
     */
    protected $file;

    /**
     * @var string
     */
    protected $alt;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var int
     */
    protected $width;

    /**
     * @return File[]
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File[] $file
     */
    public function setFile($file)
    {
        $this->file = $file;

        // calculate height and width
        list($width, $height) = getimagesize($file);
        $this->width  = $width;
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

} 
