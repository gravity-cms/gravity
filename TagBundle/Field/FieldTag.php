<?php

namespace Gravity\TagBundle\Field;

use Gravity\TagBundle\Field\Display\TagHtmlDisplay;
use Gravity\TagBundle\Field\Widget\AutoComplete\TagAutoCompleteWidget;
use Gravity\Component\Field\AbstractFieldDefinition;
use Gravity\Component\Field\Display\DisplayInterface;
use Gravity\Component\Field\Widget\WidgetDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldTag extends AbstractFieldDefinition
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

    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'multiple'  => true,
                'allow_new' => true,
            ]
        );
        $optionsResolver->setRequired(['tag']);
    }

    /**
     * @return WidgetDefinitionInterface
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
