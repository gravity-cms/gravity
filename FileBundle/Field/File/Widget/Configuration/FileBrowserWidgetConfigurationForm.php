<?php

namespace Gravity\FileBundle\Field\File\Widget\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FileBrowserWidgetConfigurationForm
 *
 * @package Gravity\TagBundle\Field\File\Widget\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileBrowserWidgetConfigurationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_type' => 'Gravity\FileBundle\Entity\FieldFile'
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_file_widget_file_browser_configuration';
    }

}
