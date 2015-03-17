<?php

namespace Gravity\TagBundle\Field\Configuration;

use Gravity\TagBundle\Entity\Tag;
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
    /**
     * The tag category ID
     *
     * @var int
     */
    protected $tag = null;

    /**
     * Allow new tags to be added
     *
     * @var boolean
     */
    protected $allowNew = false;

    /**
     * Allow multiple selections
     *
     * @var bool
     */
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
    public function setTag(Tag $tag)
    {
        $this->tag = $tag->getId();
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

    /**
     * @return boolean
     */
    public function isAllowNew()
    {
        return $this->allowNew;
    }

    /**
     * @param boolean $allowNew
     */
    public function setAllowNew($allowNew)
    {
        $this->allowNew = $allowNew;
    }
} 
