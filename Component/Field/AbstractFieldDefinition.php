<?php

namespace Gravity\Component\Field;

use Gravity\Component\Field\Display\DisplayInterface;
use Gravity\Component\Field\Widget\WidgetDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;

abstract class AbstractFieldDefinition implements FieldDefinitionInterface
{
    /**
     * @return WidgetDefinitionInterface
     */
    public function getDefaultWidget()
    {
    }

    /**
     * @return DisplayInterface
     */
    public function getDefaultDisplay()
    {
    }

    /**
     * @param OptionsResolver $optionsResolver
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
    }

    /**
     * Return an array of constraints to be applied in each widget
     *
     * @param array $options
     *
     * @return Constraint[]
     */
    public function getConstraints(array $options)
    {
        return [];
    }
}
