<?php

namespace Gravity\NodeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentTypeFormViewForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fields', 'collection', array(
                'type' => new ContentTypeFormViewFieldForm(),
                'options' => array(
                    'data_class' => 'Gravity\CoreBundle\Entity\Field',
                ),
            ))
        ;
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gravity\NodeBundle\Entity\ContentType'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_node_content_type_form_view';
    }
}
