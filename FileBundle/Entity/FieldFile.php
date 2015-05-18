<?php

namespace Gravity\FileBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gravity\CoreBundle\Entity\FieldData;

/**
 * Class FieldFile
 *
 * @package Gravity\FileBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldFile extends FieldData
{
    /**
     * @var File[]
     */
    protected $files;

    function __construct()
    {
        $this->files = new ArrayCollection();
    }

    /**
     * @param File $file
     */
    public function addFile(File $file)
    {
        $this->files[] = $file;
    }

    /**
     * @param File $file
     */
    public function removeFile(File $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * @return File
     */
    public function getFiles()
    {
        return $this->files;
    }
} 
