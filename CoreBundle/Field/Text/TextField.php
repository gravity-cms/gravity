<?php

namespace Gravity\CoreBundle\Field\Text;

use Gravity\Component\Field\AbstractFieldDefinition;
use Gravity\Component\Field\Display\DisplayInterface;
use Gravity\Component\Field\Widget\WidgetDefinitionInterface;
use Gravity\CoreBundle\Field\Text\Configuration\TextFieldConfiguration;
use Gravity\CoreBundle\Field\Text\Display\TextFieldDisplay;
use Gravity\CoreBundle\Field\Text\Widget\Formatted\FormattedWidget;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextField extends AbstractFieldDefinition
{
    protected $widget;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Text';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * @return WidgetDefinitionInterface
     */
    public function getDefaultWidget()
    {
        return new FormattedWidget();
    }

    /**
     * @return DisplayInterface
     */
    public function getDefaultDisplay()
    {
        return new TextFieldDisplay();
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\CoreBundle\Entity\FieldText';
    }

    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'multiline' => false,
                'max_chars' => null,
            ]
        );
    }
}
