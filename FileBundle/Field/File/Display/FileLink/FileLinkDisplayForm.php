<?php

namespace Gravity\FileBundle\Field\File\Display\FileLink;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class FileLinkDisplayForm
 *
 * @package Gravity\FileBundle\Field\File\Display\FileLink
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileLinkDisplayForm extends AbstractType
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
        return 'field_file_display_file_link';
    }

}
