<?php

namespace Gravity\CoreBundle\Field\Text\Widget\UnFormatted;

use Gravity\Component\Field\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class UnFormattedWidgetForm
 *
 * @package Gravity\CoreBundle\Field\Text\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class UnFormattedWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Field $field */
        $field = $options['field'];
        $fieldSettings = $field->getSettings();
        $limit = $fieldSettings['limit'];
        $widgetSettings = $field->getWidget()->getSettings();

        if($widgetSettings['multiline']){
            $builder
                ->add('body', 'textarea', [
                    'label' => $limit == 1 ? $fieldSettings['label'] : false,
                    'attr'  => [
                        'class'      => 'form-control',
                        'data-limit' => $limit,
                    ],
                ]);
        } else {
            $builder
                ->add('body', 'text', [
                    'label' => $limit == 1 ? $fieldSettings['label'] : false,
                    'attr'  => [
                        'class'      => 'form-control',
                        'data-limit' => $limit,
                    ],
                ]);
        }
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
