<?php

namespace Gravity\NodeBundle\Field\Text\Widget\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TextFieldWidgetConfigurationForm
 *
 * @package Gravity\NodeBundle\Field\Text\Widget\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextFieldWidgetConfigurationForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('useEditor', 'checkbox', [
                'required' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_type' => 'Gravity\NodeBundle\Field\Text\Widget\Configuration\TextFieldWidgetConfiguration'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_field_text_widget_settings';
    }

}
