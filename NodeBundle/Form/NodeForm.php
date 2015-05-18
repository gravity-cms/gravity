<?php

namespace Gravity\NodeBundle\Form;

use Gravity\NodeBundle\Entity\Node;
use Gravity\NodeBundle\Structure\Model\ContentType;
use GravityCMS\Component\Field\FieldManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var ContentType $contentType */
        $contentType = $options['content_type'];
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($contentType){
                $node = $event->getData();
                $form = $event->getForm();

                if (!$node instanceof Node) {
                    throw new \Exception('Form entity must be of type Node');
                }

                $form->add(
                    'fields',
                    'field_collection',
                    [
                        'label'        => false,
                        'node'         => $node,
                        'fields'       => $contentType->getFields(),
                        'by_reference' => false,
                    ]
                );
            }
        );

        $builder
            ->add('title', 'text')
            ->add(
                'description',
                'text',
                [
                    'required' => false
                ]
            )
            ->add('published', 'checkbox')
            ->add(
                'publishedOn',
                'datetime',
                [
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text',
                ]
            );
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['content_type']);
        $resolver->setAllowedTypes(
            [
                'content_type' => 'Gravity\NodeBundle\Structure\Model\ContentType',
            ]
        );
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\NodeBundle\Entity\Node',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_node';
    }
}
