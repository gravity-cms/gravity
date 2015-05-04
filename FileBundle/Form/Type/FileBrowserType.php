<?php

namespace Gravity\FileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FileBrowserType
 *
 * @package Gravity\FileBundle\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileBrowserType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired('mime_types')
            ->setAllowedTypes([
                'mime_types' => 'array',
            ])
            ->setDefaults([
                'class' => 'Gravity\FileBundle\Entity\File',
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
        return 'file_browser';
    }

    public function getParent()
    {
        return 'hidden_entity';
    }
}
