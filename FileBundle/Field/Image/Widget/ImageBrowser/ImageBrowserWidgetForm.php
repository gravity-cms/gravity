<?php


namespace Gravity\FileBundle\Field\Image\Widget\ImageBrowser;

use Gravity\FileBundle\Field\File\Configuration\FileFieldConfiguration;
use GravityCMS\CoreBundle\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageBrowserWidgetForm
 *
 * @package Gravity\FileBundle\Field\Image\Widget\ImageBrowser
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageBrowserWidgetForm extends AbstractType
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
            ->add('file', 'image_browser', [
                'label'      => $limit == 1 ? null : $field->getLabel(),
                'mime_types' => ['image/*'],
            ])
            ->add('alt', 'text')
            ->add('title', 'text');
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
