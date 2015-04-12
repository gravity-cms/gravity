<?php


namespace Gravity\FileBundle\ImageStyler\Operation\GDOptimiser\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class GDOptimiserConfigurationForm
 *
 * @package Gravity\FileBundle\ImageStyler\Operation\GDOptimiser\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class GDOptimiserConfigurationForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quality', 'integer');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Gravity\FileBundle\ImageStyler\Operation\GDOptimiser\Configuration\GDOptimiserConfiguration',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'operation_gd_optimiser_configuration';
    }
}
