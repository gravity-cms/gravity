<?php


namespace Gravity\CoreBundle\Field\Boolean\Widget\Select;

use Gravity\Component\Field\Field;
use Gravity\CoreBundle\Field\Choice\Widget\Select\DataTransformer\ChoiceArrayToStringDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SelectWidgetForm
 *
 * @package Gravity\CoreBundle\Field\Boolean\Widget\Select
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SelectWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Field $field */
        $field          = $options['field'];
        $fieldSettings  = $field->getSettings();
        $widgetSettings = $field->getWidget()->getSettings();

        $builder
            ->add(
                'value',
                'choice',
                [
                    'empty_data' => [],
                    'choices'    => [
                        true  => $widgetSettings['true_option'],
                        false => $widgetSettings['false_option'],
                    ],
                    'multiple'   => false,
                    'required'   => $fieldSettings['required'],
                    'expanded'   => $widgetSettings['expanded'] ? true : false,
                    'label'      => $fieldSettings['label']
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\CoreBundle\Entity\FieldBoolean'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_field_boolean_widget_select';
    }
}
