<?php

namespace Gravity\NodeBundle\Form;

use Gravity\NodeBundle\Entity\ContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentTypeForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', 'text')
            ->add('description', 'text', [
                'required' => false
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $data = $event->getData();

            if($data instanceof ContentType && !$data->getId()){
                $event->getForm()
                    ->add('name', 'text');
            }
        });
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Gravity\NodeBundle\Entity\ContentType'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_node_content_type';
    }
}
