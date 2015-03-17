<?php

namespace Gravity\NodeBundle\Field\Text\Widget\Form;

use Gravity\NodeBundle\Entity\ContentTypeField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TextFieldWidgetForm
 *
 * @package Gravity\NodeBundle\Field\Text\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextFieldWidgetForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var ContentTypeField $contentTypeField */
        $contentTypeField = $options['content_type_field'];
        $limit = $contentTypeField->getConfig()->getLimit();
        $builder
            ->add('body', 'textarea', [
                'label' => $limit == 1 ? $contentTypeField->getLabel() : false,
                'attr' => [
                    'class' => 'form-control wysiwyg-editor',
                    'data-limit' => $limit,
                ],
            ]);
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\NodeBundle\Entity\FieldText',
            ]
        );

        $resolver->setRequired(['content_type_field']);
        $resolver->setAllowedTypes([
            'content_type_field' => 'Gravity\NodeBundle\Entity\ContentTypeField',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_field_text_widget';
    }
}
