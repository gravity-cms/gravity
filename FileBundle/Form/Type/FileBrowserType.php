<?php

namespace Gravity\FileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class FileBrowserType
 *
 * @package Gravity\FileBundle\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileBrowserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
        return 'gravity_file';
    }

}
