<?php

namespace Gravity\TagBundle\Form;

use Doctrine\ORM\EntityRepository;
use Gravity\TagBundle\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TagForm
 *
 * @package Gravity\TagBundle\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('parentTag', 'tag_choice', [
                'class' => 'Gravity\TagBundle\Entity\Tag',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.parentTag IS NULL')
                        ->orderBy('u.name', 'ASC');
                },
                'property' => 'name',
                'empty_value' => '',
                'empty_data' => null,
                'required' => false,
            ])
            ->add('description');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $tag = $event->getData();
            if($tag instanceof Tag && $tag->getId()){
                $event->getForm()->remove('parentTag');
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
            'data_class' => 'Gravity\TagBundle\Entity\Tag'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_tag';
    }
}
