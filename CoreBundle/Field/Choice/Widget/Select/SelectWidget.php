<?php


namespace Gravity\CoreBundle\Field\Choice\Widget\Select;

use Gravity\Component\Field\FieldDefinitionInterface;
use Gravity\Component\Field\Widget\AbstractWidgetDefinition;

/**
 * Class SelectWidget
 *
 * @package gravity\CoreBundle\Field\Choice\Widget\Select
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class SelectWidget extends AbstractWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'choice.select';
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
        return 'Choice Using a Dropdown Box';
    }

    public function getForm()
    {
        return new SelectWidgetForm();
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
