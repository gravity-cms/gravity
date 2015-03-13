<?php

namespace Gravity\TagBundle\Field\Configuration;

use Gravity\TagBundle\Field\Configuration\Form\FieldTagSettingsForm;
use GravityCMS\Component\Field\Configuration\FieldSettingsConfiguration;

/**
 * Class FieldTagConfiguration
 *
 * @package Gravity\TagBundle\Field\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTagConfiguration extends FieldSettingsConfiguration
{
    protected $tag;

    protected $multiple = true;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'field.tag';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return new FieldTagSettingsForm();
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @param boolean $multiple
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;
    }
} 
