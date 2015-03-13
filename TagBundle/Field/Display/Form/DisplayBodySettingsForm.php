<?php

namespace Gravity\TagBundle\Field\Display\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class TagHtmlDisplaySettingsForm
 *
 * @package Gravity\TagBundle\Field\Display\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagHtmlDisplaySettingsForm extends AbstractType
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
        return 'field_type_tag_display_html_settings';
    }

}
