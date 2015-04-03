<?php

namespace Gravity\FileBundle\Document;

use Gravity\FileBundle\Entity\File as FileEntity;

/**
 * Class File
 *
 * @package Nefarian\CmsBundle\Plugin\File\Document
 */
class File
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $credits;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array Array of all api urls
     */
    protected $_api;


    /**
     * @param FileEntity $file
     * @param array                           $api
     */
    function __construct(FileEntity $file, array $api = [])
    {
        $this->id          = $file->getId();
        $this->name       = $file->getName();
        $this->description = $file->getDescription();
        $this->path        = $file->getPath();
        $this->size        = $file->getSize();
        $this->status      = $file->getStatus();
        $this->filename    = $file->getFilename();
        $this->_api        = $api;

    }

    /**
     * @return array
     */
    public function getApi()
    {
        return $this->_api;
    }

    /**
     * @return string
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

} 
