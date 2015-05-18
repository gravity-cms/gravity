<?php

namespace Gravity\TagBundle\Field\Widget\Select;

use Gravity\Component\Field\FieldDefinitionInterface;
use Gravity\Component\Field\Widget\AbstractWidgetDefinition;

/**
 * Class TagSelectWidget
 *
 * @package Gravity\TagBundle\Field\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagSelectWidget extends AbstractWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tag.select';
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
     * @param FieldDefinitionInterface $field
     *
     * @return string
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return ($field->getName() === 'tag');
    }

}
