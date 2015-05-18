<?php

namespace Gravity\Component\Field\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldWidgetConfigurationType
 *
 * @package Gravity\Component\Field\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldWidgetConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'default',
                'text',
                [
                    'required' => false,
                ]
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['field_config']);
        $resolver->setAllowedTypes(
            [
                'field_config' => '\Gravity\Component\Field\Configuration\FieldSettingsConfiguration',
            ]
        );
        $resolver->setDefaults(
            [
                'data_class' => '\Gravity\Component\Field\Widget\WidgetSettingsInterface',
            ]
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'field_widget_configuration';
    }
}
