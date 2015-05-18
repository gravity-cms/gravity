<?php

namespace Gravity\CoreBundle\Form\Block;

use Doctrine\ORM\EntityRepository;
use Gravity\CoreBundle\Entity\LayoutPosition;
use Gravity\CoreBundle\View\Block\Text\TextBlock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TextBlockForm
 *
 * @package Gravity\CoreBundle\Form\Block
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextBlockForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', 'textarea', array(
            'label' => 'Text Text'
        ));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            if (!$data instanceof TextBlock || !$data->getPosition() instanceof LayoutPosition) {
                $event->getForm()->add('position', 'entity', array(
                    'class'         => 'Gravity\CoreBundle\Entity\LayoutPosition',
                    'property'      => 'name',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('l')
                            ->orderBy('l.name', 'ASC');
                    },
                ));
            }
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\Gravity\CoreBundle\Entity\BlockText'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'configuration_block_text';
    }

}
