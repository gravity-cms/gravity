<?php

namespace Gravity\Component\Field;

use Gravity\Component\Field\Display\DisplayInterface;
use Gravity\Component\Field\Widget\WidgetDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;

/**
 * Interface FieldDefinitionInterface
 *
 * @package Gravity\Component\Field
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface FieldDefinitionInterface
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName();

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get the description of the field
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass();

    /**
     * @param OptionsResolver $optionsResolver
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver);

    /**
     * @return WidgetDefinitionInterface
     */
    public function getDefaultWidget();

    /**
     * @return DisplayInterface
     */
    public function getDefaultDisplay();

    /**
     * Return an array of constraints to be applied in each widget
     *
     * @param array $options
     *
     * @return Constraint[]
     */
    public function getConstraints(array $options);
}
