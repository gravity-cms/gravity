<?php


namespace Gravity\CoreBundle\Field\Number;

use Gravity\Component\Field\AbstractFieldDefinition;
use Gravity\Component\Field\Configuration\FieldSettingsConfiguration;
use Gravity\Component\Field\Display\DisplayInterface;
use Gravity\Component\Field\Widget\WidgetDefinitionInterface;
use Gravity\CoreBundle\Entity\FieldNumber;
use Gravity\CoreBundle\Field\Number\Configuration\NumberFieldConfiguration;
use Gravity\CoreBundle\Field\Number\Display\Number\NumberDisplay;
use Gravity\CoreBundle\Field\Number\Widget\NumberBox\NumberBoxWidget;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NumberField
 *
 * @package Gravity\CoreBundle\Field\Number
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NumberField extends AbstractFieldDefinition
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'number';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Number';
    }

    /**
     * Get the description of the field
     *
     * @return string
     */
    public function getDescription()
    {
        return 'A numerical field';
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\CoreBundle\Entity\FieldNumber';
    }

    /**
     * @return DisplayInterface
     */
    public function getDefaultDisplay()
    {
        return new NumberDisplay();
    }

    /**
     * @return WidgetDefinitionInterface
     */
    public function getDefaultWidget()
    {
        return new NumberBoxWidget();
    }

    /**
     * Set the default value of an entity, given a configuration instance
     *
     * @param FieldNumber                $entity
     * @param FieldSettingsConfiguration $configuration
     *
     * @return void
     */
    public function setDefaults($entity, FieldSettingsConfiguration $configuration)
    {
        $entity->setNumber($configuration->getDefault());
    }

    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'accuracy' => 1,
                'min'      => null,
                'max'      => null,
                'step'     => null,
            ]
        );
    }

}
