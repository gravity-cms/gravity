<?php

namespace Gravity\FileBundle\Field\File\Widget;

use Gravity\NodeBundle\Entity\ContentTypeField;
use Gravity\TagBundle\Field\Configuration\FieldTagConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
        /** @var FieldTagConfiguration $configuration */
        /** @var ContentTypeField $typeField */
        $typeField     = $options['content_type_field'];
        $configuration = $typeField->getConfig();
        $limit         = $configuration->getLimit();

        $builder
            ->add('files', 'file_collection', [
                'type'    => 'hidden_entity',
                'options' => [
                    'class' => '\Gravity\FileBundle\Entity\File'
                ],
                //'multiple'        => $configuration->isMultiple(),
                //'limit'           => (int)$limit,
                'label'   => $limit == 1 ? null : $typeField->getLabel(),
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
                'data_class' => '\Gravity\FileBundle\Entity\FieldFile'
            ]
        );

        $resolver->setRequired(['content_type_field']);
        $resolver->setAllowedTypes([
            'content_type_field' => '\Gravity\NodeBundle\Entity\ContentTypeField',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'field_file_widget_file_browser';
    }
}
