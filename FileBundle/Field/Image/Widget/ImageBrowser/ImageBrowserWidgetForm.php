<?php


namespace Gravity\FileBundle\Field\Image\Widget\ImageBrowser;

use Gravity\Component\Field\Field;
use Gravity\FileBundle\Field\Image\Configuration\ImageFieldConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageBrowserWidgetForm
 *
 * @package Gravity\FileBundle\Field\Image\Widget\ImageBrowser
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageBrowserWidgetForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var ImageFieldConfiguration $configuration */
        /** @var Field $field */
        $field         = $options['field'];
        $configuration = $field->getSettings();
        $limit         = $configuration['limit'];

        $widgetConfig = $field->getWidget()->getSettings();

        $builder->add(
            'file',
            'image_browser',
            [
                // 'label'       => $limit == 1 ? null : $field->getLabel(),
                'mime_types'  => ['image/*'],
                'image_style' => $widgetConfig['image_style'],
            ]
        );

        if ($configuration['alt_field']) {
            $builder->add(
                'alt',
                'text',
                [
                    'required' => $configuration['alt_required']
                ]
            );
        }

        if ($configuration['title_field']) {
            $builder->add(
                'title',
                'text',
                [
                    'required' => $configuration['title_required']
                ]
            );
        }
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\FileBundle\Entity\FieldImage'
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
        return 'field_image_widget_image_browser';
    }
}
