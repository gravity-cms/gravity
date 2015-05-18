<?php

namespace Gravity\CoreBundle\Form;

use Gravity\CoreBundle\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldForm
 *
 * @package Gravity\CoreBundle\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldForm extends AbstractType
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
            ->add('field_type', 'gravity_field_type')
            ->add('delta', 'hidden')
        ;

        $builder->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event){
            $data = $event->getData();
            $form = $event->getForm();

            if($data instanceof Field && $data->getId()){
                $form
                    ->remove('name')
                    ->remove('field_type');
            }

        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Gravity\CoreBundle\Entity\Field'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_field';
    }
}
