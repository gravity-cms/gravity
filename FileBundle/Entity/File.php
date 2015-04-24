<?php

namespace Gravity\FileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Class File
 *
 * @package Gravity\FileBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @JMS\ExclusionPolicy("all")
 */
class File
{
    /**
     * @var int
     *
     * @JMS\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @JMS\Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @JMS\Expose
     */
    protected $description;

    /**
     * filesystem name to use
     *
     * @var string
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     *
     * @JMS\Expose
     */
    protected $url;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var \DateTime
     *
     * @JMS\Expose
     */
    protected $createdOn;

    /**
     * @var \DateTime
     *
     * @JMS\Expose
     */
    protected $editedOn;

    /**
     * @var int
     */
    protected $status = 0;

    function __construct()
    {
        $this->createdOn = new \DateTime();
    }

    function __toString()
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;
    }

    /**
     * @return \DateTime
     */
    public function getEditedOn()
    {
        return $this->editedOn;
    }

    /**
     * @param \DateTime $editedOn
     */
    public function setEditedOn(\DateTime $editedOn)
    {
        $this->editedOn = $editedOn;
    }

    /**
     * @return string
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @param string $filesystem
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getFile()
    {
        return new \Symfony\Component\HttpFoundation\File\File($this->path, false);
    }
} 
