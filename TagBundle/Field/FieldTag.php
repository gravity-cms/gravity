<?php

namespace Gravity\TagBundle\Field;

use Gravity\Component\Field\AbstractFieldDefinition;
use Gravity\TagBundle\Field\Display\TagHtmlDisplay;
use Gravity\TagBundle\Field\Widget\AutoComplete\TagAutoCompleteWidget;
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

    /**
     * {@inheritdoc}
     */
    public function getDefaultWidget()
    {
        return new TagAutoCompleteWidget();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDisplay()
    {
        return new TagHtmlDisplay();
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return 'Gravity\TagBundle\Entity\FieldTag';
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

}
