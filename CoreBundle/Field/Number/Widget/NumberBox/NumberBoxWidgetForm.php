<?php


namespace Gravity\CoreBundle\Field\Number\Widget\NumberBox;

use Gravity\Component\Field\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class NumberBoxWidgetForm
 *
 * @package Gravity\CoreBundle\Field\Number\Widget\NumberBox
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NumberBoxWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Field $field */
        $field = $options['field'];
        $fieldConfig = $field->getSettings();
        $limit       = $fieldConfig['limit'];

        $builder
            ->add(
                'number',
                'number',
                [
                    'label' => $limit == 1 ? $fieldConfig['label'] : false,
                    'attr'  => [
                        'class'      => 'form-control',
                        'data-limit' => $limit,
                        'step'       => $fieldConfig['step'],
                        'min'        => $fieldConfig['min'],
                        'max'        => $fieldConfig['max'],
                    ],
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
                'data_class' => 'Gravity\CoreBundle\Entity\FieldNumber',
            ]
        );
    }

    public function getParent()
    {
        return 'field_widget';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_field_number_widget_numberbox';
    }
}

