<?php

namespace Gravity\TagBundle\Field\Widget\AutoComplete\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TagAutoCompleteWidgetConfigurationForm
 *
 * @package Gravity\TagBundle\Field\Widget\AutoComplete\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagAutoCompleteWidgetConfigurationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_type' => 'Gravity\TagBundle\Entity\FieldTag'
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_tag_widget_autocomplete_configuration';
    }

}
