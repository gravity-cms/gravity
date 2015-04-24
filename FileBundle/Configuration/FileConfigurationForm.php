<?php

namespace Gravity\FileBundle\Configuration;

use Gaufrette\Filesystem;
use Gravity\FileBundle\File\StreamWrapper\StreamWrapperManager;
use Knp\Bundle\GaufretteBundle\FilesystemMap;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class FileConfigurationForm
 *
 * @package Gravity\FileBundle\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileConfigurationForm extends AbstractType
{
    /**
     * @var FilesystemMap
     */
    protected $filesystemMap;

    function __construct(FilesystemMap $filesystemMap)
    {
        $this->filesystemMap = $filesystemMap;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $filesystems = [];
        /** @var Filesystem $filesystem */
        foreach ($this->filesystemMap as $name => $filesystem) {
            $filesystems[$name] = ucfirst($name);
        }

        $builder->add('defaultFilesystem', 'choice', [
            'label'    => 'Default Filesystem',
            'choices'  => $filesystems,
            'expanded' => true,
            'multiple' => false,
        ])
        ->add('allowedExtensions', 'text_list');
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'file_configuration';
    }

}
