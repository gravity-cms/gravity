<?php

namespace Gravity\NodeBundle\Field\Text\Display\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class TextFieldDisplaySettingsForm
 *
 * @package Gravity\NodeBundle\Field\Text\Display\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextFieldDisplaySettingsForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('useEditor', 'checkbox');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_type_text_display_html_settings';
    }

}
