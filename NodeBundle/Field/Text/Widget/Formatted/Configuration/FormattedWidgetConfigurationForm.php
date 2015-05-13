<?php

namespace Gravity\NodeBundle\Field\Text\Widget\Formatted\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FormattedWidgetConfigurationForm
 *
 * @package Gravity\NodeBundle\Field\Text\Widget\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FormattedWidgetConfigurationForm extends AbstractType
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
            'data_type' => 'Gravity\NodeBundle\Field\Text\Widget\Configuration\FormattedWidgetConfiguration'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_field_text_widget_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field_widget_configuration';
    }
}
