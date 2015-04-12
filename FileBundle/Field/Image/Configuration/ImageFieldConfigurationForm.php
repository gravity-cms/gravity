<?php


namespace Gravity\FileBundle\Field\Image\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageFieldConfigurationForm
 *
 * @package Gravity\FileBundle\Field\Image\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageFieldConfigurationForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Gravity\FileBundle\Field\Image\Configuration\ImageFieldConfiguration',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_image_configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field_configuration';
    }
}
