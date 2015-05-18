<?php

namespace Gravity\Component\Field\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldConfigurationType
 *
 * @package Gravity\Component\Field\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('limit', 'toggle', [
                'type'           => 'number',
                'disabled_value' => -1,
            ])
            ->add('required', 'checkbox', [
                'required' => false,
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Gravity\Component\Field\Configuration\FieldSettingsConfiguration',
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'field_configuration';
    }
}
