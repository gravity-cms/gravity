<?php

namespace Gravity\FileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageBrowserType
 *
 * @package Gravity\FileBundle\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageBrowserType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'mime_types' => ['image/*'],
            ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['mime_types'] = $options['mime_types'];
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'image_browser';
    }

    public function getParent()
    {
        return 'file_browser';
    }


}
