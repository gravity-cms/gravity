<?php

namespace Gravity\Component\Form\Type;

use Gravity\Component\Form\DataTransformer\ToggleDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ToggleType
 *
 * @package Gravity\Component\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ToggleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled', 'checkbox', [
                'required' => false,
            ])
            ->add('value', $options['type'], $options['options'])
            ->addModelTransformer(new ToggleDataTransformer($options['disabled_value']));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'type',
            'disabled_value',
        ]);

        $resolver->setDefaults([
            'options' => [],
        ]);

        $resolver->setAllowedTypes([
            'type' => 'string',
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {

    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'toggle';
    }
}
