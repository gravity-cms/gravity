<?php


namespace Gravity\FileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageStyleForm
 *
 * @package Gravity\FileBundle\Form
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('label')
            ->add('description', 'textarea');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Gravity\FileBundle\Entity\ImageStyle'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'image_style';
    }
}
