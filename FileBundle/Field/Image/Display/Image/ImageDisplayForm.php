<?php


namespace Gravity\FileBundle\Field\Image\Display\Image;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ImageDisplayForm
 *
 * @package Gravity\FileBundle\Field\Image\Display\Image
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageDisplayForm extends AbstractType
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
        return 'field_image_display_image';
    }

}
