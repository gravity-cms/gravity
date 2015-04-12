<?php

namespace Gravity\TagBundle\Field;

use Gravity\TagBundle\Field\Configuration\FieldTagConfiguration;
use Gravity\TagBundle\Field\Display\TagHtmlDisplay;
use Gravity\TagBundle\Field\Widget\AutoComplete\TagAutoCompleteWidget;
use GravityCMS\Component\Field\AbstractField;
use GravityCMS\Component\Field\Display\DisplayInterface;
use GravityCMS\Component\Field\Widget\WidgetInterface;

class FieldTag extends AbstractField
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Tag';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSettings()
    {
        return new FieldTagConfiguration();
    }

    /**
     * @return WidgetInterface
     */
    public function getDefaultWidget()
    {
        return new TagAutoCompleteWidget();
    }

    /**
     * @return DisplayInterface
     */
    public function getDefaultDisplay()
    {
        return new TagHtmlDisplay();
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\TagBundle\Entity\FieldTag';
    }

}
