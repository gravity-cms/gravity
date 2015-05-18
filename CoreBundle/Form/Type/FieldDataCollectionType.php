<?php

namespace Gravity\CoreBundle\Form\Type;

use Gravity\CoreBundle\Form\DataTransformer\FieldContentCollectionDataTransformer;
use Gravity\CoreBundle\Form\DataTransformer\FieldDataCollectionDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldDataCollectionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new FieldDataCollectionDataTransformer($options['field']));
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'field',
            'limit'
        ]);

        $resolver->setAllowedTypes([
            'field' => 'Gravity\Component\Field\Field',
            'limit' => 'integer',
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['field'] = $options['field'];
        $view->vars['limit'] = $options['limit'];
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'field_data_collection';
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return 'collection';
    }


} 
