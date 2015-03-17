<?php

namespace Gravity\NodeBundle\Form\Type;

use Gravity\NodeBundle\Form\DataTransformer\FieldContentCollectionDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldContentCollectionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new FieldContentCollectionDataTransformer($options['type_field']));
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'type_field',
            'limit'
        ));

        $resolver->setAllowedTypes(array(
            'type_field' => 'Gravity\NodeBundle\Entity\ContentTypeField',
            'limit' => 'integer',
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['type_field'] = $options['type_field'];
        $view->vars['limit'] = $options['limit'];
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'field_content_collection';
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return 'collection';
    }


} 
