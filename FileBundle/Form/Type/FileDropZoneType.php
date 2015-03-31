<?php

namespace Gravity\FileBundle\Form\Type;

use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\File\Document\File as FileDocument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FileDropZoneType
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileDropZoneType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired([
                'form_id'
            ])
            ->setDefaults([
                'limit' => 1,
                'allow_add' => true,
                'allow_delete' => true,
                'data_type' => 'Gravity\FileBundle\Entity\File',
                'mime_types' => [],
            ])
            ->setAllowedTypes([
                'form_id' => 'integer',
                'limit' => 'integer',
                'mime_types' => 'array',
            ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['files'] = [];
        if ($view->vars['value']) {
            foreach ($view->vars['value'] as $child) {
                if ($child instanceof File) {
                    $view->vars['files'][] = new FileDocument($child);
                }
            }
        }
        $view->vars['mimeTypes'] = $options['mime_types'];
        $view->vars['limit']     = $options['limit'];
        $view->vars['form_id']   = $options['form_id'];
    }

    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'file_dropzone';
    }
}
