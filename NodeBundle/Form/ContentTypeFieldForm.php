<?php

namespace Gravity\NodeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentTypeFieldForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', 'text')
            ->add('name', 'text')
            ->add('field', 'entity', array(
                'class' => 'GravityCMS\CoreBundle\Entity\Field',
                'property' => 'name',
            ))
            ->add('order', 'hidden')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gravity\NodeBundle\Entity\ContentTypeField'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_node_content_type_field';
    }
}
