<?php


namespace Gravity\CoreBundle\Field\Choice;

use Gravity\Component\Field\AbstractFieldDefinition;
use Gravity\CoreBundle\Field\Choice\Widget\Select\SelectWidget;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Count;

/**
 * Class ChoiceField
 *
 * @package Gravity\CoreBundle\Field\Choice
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ChoiceField extends AbstractFieldDefinition
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'choice';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Choice list';
    }

    /**
     * Get the description of the field
     *
     * @return string
     */
    public function getDescription()
    {
        return 'A list of pre-defined choices';
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\CoreBundle\Entity\FieldChoice';
    }

    /**
     * @return SelectWidget
     */
    public function getDefaultWidget()
    {
        return new SelectWidget();
    }

    /**
     * @param OptionsResolver $optionsResolver
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver
            ->setRequired(
                [
                    'choices'
                ]
            )
            ->setAllowedTypes(
                [
                    'choices' => 'array',
                ]
            )
            ->setDefaults(
                [
                    'multiple' => false,
                ]
            );
    }

    /**
     * @param array $options
     *
     * @return \Symfony\Component\Validator\Constraint[]
     */
    public function getConstraints(array $options)
    {
        $constraints = [
            'value' => [
                new Choice(
                    [
                        'choices' => $options['choices']
                    ]
                ),
            ]
        ];

        if (!$options['multiple']) {
            $constraints['value'][] = new Count(
                [
                    'max' => 1
                ]
            );
        }

        return [];
    }

}
