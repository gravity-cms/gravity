<?php

namespace Gravity\Component\Field;

use Gravity\Component\Field\Display\DisplayInterface;
use Gravity\Component\Field\Widget\WidgetDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
}
