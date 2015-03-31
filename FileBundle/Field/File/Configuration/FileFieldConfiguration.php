<?php

namespace Gravity\FileBundle\Field\File\Configuration;

use GravityCMS\Component\Field\Configuration\FieldSettingsConfiguration;

/**
 * Class FileFieldConfiguration
 *
 * @package Gravity\FileBundle\Field\File\FileFieldConfiguration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileFieldConfiguration extends FieldSettingsConfiguration
{
    /**
     * The tag category ID
     *
     * @var int
     */
    protected $mimeTypes = [
        'image/*',
    ];

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'field.file';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return new FileFieldConfigurationForm();
    }

    /**
     * @return int
     */
    public function getMimeTypes()
    {
        return $this->mimeTypes;
    }

    /**
     * @param int $mimeTypes
     */
    public function setMimeTypes($mimeTypes)
    {
        $this->mimeTypes = $mimeTypes;
    }
} 
