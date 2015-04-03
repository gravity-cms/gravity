<?php

namespace Gravity\NodeBundle\Field\Text\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TextFieldConfigurationForm
 *
 * @package Gravity\NodeBundle\Field\Text\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextFieldConfigurationForm extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Gravity\NodeBundle\Field\Text\Configuration\TextFieldConfiguration',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_field_text_configuration';
    }

    public function getParent()
    {
        return 'field_configuration';
    }
}
