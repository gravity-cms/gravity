<?php


namespace Gravity\FileBundle\Field\Image\Display\Image\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImageDisplayConfigurationForm
 *
 * @package Gravity\FileBundle\Field\Image\Display\Image\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageDisplayConfigurationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('useEditor', 'checkbox');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_image_display_image_configuration';
    }

}
