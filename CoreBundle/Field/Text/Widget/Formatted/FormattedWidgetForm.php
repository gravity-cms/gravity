<?php

namespace Gravity\CoreBundle\Field\Text\Widget\Formatted;

use Gravity\Component\Field\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FormattedWidgetForm
 *
 * @package Gravity\CoreBundle\Field\Text\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FormattedWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Field $field */
        $field = $options['field'];
        $limit = $field->getSettings()['limit'];
        $builder
            ->add(
                'body',
                'textarea',
                [
                    'label' => $limit == 1 ? $field->getSettings()['label'] : false,
                    'attr'  => [
                        'class'      => 'form-control wysiwyg-editor',
                        'data-limit' => $limit,
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
                'data_class' => 'Gravity\CoreBundle\Entity\FieldText',
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
        return 'gravity_field_text_widget';
    }
}
