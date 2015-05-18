<?php
namespace Gravity\Component\Theme\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LayoutForm
 *
 * @package Gravity\Component\Theme\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class LayoutForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'text');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            if ($event->getData()->getId()) {
                $event->getForm()->add('positions', 'collection', array(
                    'type'    => 'gravity_cms_layout_layout_position_block',
                    'options' => array(
                        'data_class'          => 'Gravity\CoreBundle\Entity\LayoutPositionBlock',
                        'position_data_class' => 'Gravity\CoreBundle\Entity\LayoutPosition',
                    ),
                ));
            }
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gravity\Component\Theme\Entity\Layout',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'gravity_cms_layout';
    }

}
