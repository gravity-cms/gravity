<?php

namespace Gravity\FileBundle\Field\File\Widget;

use Gravity\FileBundle\Field\File\Configuration\FileFieldConfiguration;
use Gravity\CoreBundle\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FileBrowserWidgetForm
 *
 * @package Gravity\TagBundle\Field\File\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileBrowserWidgetForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FileFieldConfiguration $configuration */
        /** @var Field $field */
        $field         = $options['field'];
        $configuration = $field->getConfig();
        $limit         = $configuration->getLimit();

        $builder
            ->add('files', 'file_collection', [
                'type'       => 'hidden_entity',
                'options'    => [
                    'class' => '\Gravity\FileBundle\Entity\File'
                ],
                'label'      => $limit == 1 ? null : $field->getLabel(),
                'mime_types' => $configuration->getMimeTypes(),
            ]);
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\FileBundle\Entity\FieldFile'
            ]
        );
    }

    public function getParent()
    {
        return 'field_widget';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'field_file_widget_file_browser';
    }
}
