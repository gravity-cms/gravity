<?php

namespace Gravity\Component\Theme\Form;

use Gravity\Component\Entity\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ViewForm
 *
 * @package Gravity\Component\Theme\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ViewForm extends AbstractType
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
        $choices = array();
        foreach ($this->entityManager->getEntityDefinitions() as $entity) {
            $choices[$entity->getName()] = $entity->getLabel();
        }

        $builder
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('route', 'basic_route', array(
                'data_class' => '\Gravity\CoreBundle\Entity\Route',
            ))
            ->add('type', 'choice', array(
                'choices' => $choices,
            ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_type' => '\Gravity\Component\Theme\Entity\View'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'gravity_cms_view';
    }
}
