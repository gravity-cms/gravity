<?php

namespace Gravity\FileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FileCollectionType
 *
 * @package Gravity\FileBundle\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileCollectionType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'type' => 'file_browser',
            'options' => [
                'class'         => 'Gravity\FileBundle\Entity\File',
            ],
            'allow_add' => true,
            'allow_delete' => true,
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'file_collection';
    }

    public function getParent()
    {
        return 'collection';
    }
}
