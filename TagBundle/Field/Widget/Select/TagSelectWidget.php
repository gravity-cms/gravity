<?php

namespace Gravity\TagBundle\Field\Widget\Select;

use GravityCMS\Component\Field\FieldInterface;
use GravityCMS\Component\Field\Widget\AbstractWidget;

/**
 * Class TagSelectWidget
 *
 * @package Gravity\TagBundle\Field\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagSelectWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.tag.widget.select';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Dropdown Box';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Tags Using Dropdown Box';
    }

    public function getForm()
    {
        return 'tag_widget_select';
    }

    public function getEntityClass()
    {
        return 'Gravity\TagBundle\Entity\FieldTag';
    }

    /**
     * Checks if this widget supports the given field
     *
     * @param FieldInterface $field
     *
     * @return string
     */
    public function supportsField(FieldInterface $field)
    {
        return ($field->getName() === 'field.type.tag');
    }

}
