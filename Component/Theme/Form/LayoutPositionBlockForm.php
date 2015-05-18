<?php

namespace Gravity\Component\Theme\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LayoutPositionBlockForm
 *
 * @package Gravity\Component\Theme\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class LayoutPositionBlockForm extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('position', 'hidden_entity', array(
            'class' => $options['position_data_class'],
            'em' => $this->entityManager,
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'position_data_class'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'gravity_cms_layout_layout_position_block';
    }

}
