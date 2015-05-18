<?php

namespace Gravity\Component\Field;

use Gravity\Component\Field\Display\DisplayInterface;
use Gravity\Component\Field\Widget\WidgetDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldManager
{
    /**
     * @var FieldDefinitionInterface[]
     */
    protected $fieldsDefinitions = [];

    /**
     * @var DisplayInterface[]
     */
    protected $fieldDisplays = [];

    /**
     * @var WidgetDefinitionInterface[]
     */
    protected $fieldWidgets = [];

    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     * Add a field to the manager
     *
     * @param FieldDefinitionInterface $field
     */
    public function addFieldDefinition(FieldDefinitionInterface $field)
    {
        $this->fieldsDefinitions[$field->getName()] = $field;
    }

    /**
     * @return FieldDefinitionInterface[]
     */
    public function getFieldDefinitions()
    {
        return $this->fieldsDefinitions;
    }

    /**
     * @param $name
     *
     * @return FieldDefinitionInterface
     */
    public function getFieldDefinition($name)
    {
        if (isset($this->fieldsDefinitions[$name])) {
            return $this->fieldsDefinitions[$name];
        }

        return null;
    }

    /**
     * @param string $type
     * @param string $name
     * @param array  $options
     *
     * @return void
     */
    public function registerField($type, $name,  array $options)
    {
        $fieldDefinition = $this->getFieldDefinition($type);
        $optionResolver  = new OptionsResolver();
        $optionResolver->setDefaults(
            [
                'limit'    => 1,
                'required' => true,
                'label'    => ucwords(str_replace('_', ' ', $name)),
            ]
        );
        $fieldDefinition->setOptions($optionResolver, $options);
        $resolvedOptions = $optionResolver->resolve($options);

        $this->fields[$type][$name] = new Field(
            $name,
            $fieldDefinition,
            $resolvedOptions
        );
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string $type
     * @param string $name
     *
     * @return Field
     */
    public function getField($type, $name)
    {
        return $this->fields[$type][$name];
    }

    /**
     * Add a field widget to the manager
     *
     * @param WidgetDefinitionInterface $widget
     */
    public function addFieldWidget(WidgetDefinitionInterface $widget)
    {
        $this->fieldWidgets[$widget->getName()] = $widget;
    }

    /**
     * @return WidgetDefinitionInterface[]
     */
    public function getFieldWidgets()
    {
        return $this->fieldWidgets;
    }

    /**
     * @param $name
     *
     * @return WidgetDefinitionInterface
     */
    public function getFieldWidget($name)
    {
        if (!isset($this->fieldWidgets[$name])) {
            throw new \Exception(
                "Widget '{$name}' not found. Allowed widgets are: " . implode(', ', array_keys($this->fieldWidgets))
            );
        }

        return $this->fieldWidgets[$name];
    }

    /**
     * Add a field widget to the manager
     *
     * @param DisplayInterface $widget
     */
    public function addFieldDisplay(DisplayInterface $widget)
    {
        $this->fieldDisplays[$widget->getName()] = $widget;
    }

    /**
     * @return DisplayInterface[]
     */
    public function getFieldDisplays()
    {
        return $this->fieldDisplays;
    }

    /**
     * @param $name
     *
     * @return DisplayInterface
     */
    public function getFieldDisplay($name)
    {
        if (array_key_exists($name, $this->fieldDisplays)) {
            return $this->fieldDisplays[$name];
        }

        return null;
    }

} 
