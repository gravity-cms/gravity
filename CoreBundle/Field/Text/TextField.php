<?php

namespace Gravity\CoreBundle\Field\Text;

use Gravity\Component\Field\AbstractFieldDefinition;
use Gravity\CoreBundle\Field\Text\Configuration\TextFieldConfiguration;
use Gravity\CoreBundle\Field\Text\Display\TextFieldDisplay;
use Gravity\CoreBundle\Field\Text\Widget\Formatted\FormattedWidget;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class TextField extends AbstractFieldDefinition
{
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
     * {@inheritdoc}
     */
    public function getDefaultWidget()
    {
        return new FormattedWidget();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDisplay()
    {
        return new TextFieldDisplay();
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return 'Gravity\CoreBundle\Entity\FieldText';
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'char_min'  => null,
                'char_max'  => null,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConstraints(array $options)
    {
        $constraints = [];
        if ($options['char_min'] !== null || $options['char_max'] !== null) {
            $constraints['body'] = new Length(
                [
                    'max' => $options['char_max'],
                    'min' => $options['char_min']
                ]
            );
        }

        return $constraints;
    }

}
