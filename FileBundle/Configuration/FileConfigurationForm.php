<?php

namespace Gravity\FileBundle\Configuration;

use Gravity\FileBundle\File\StreamWrapper\StreamWrapperManager;
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
     * @var StreamWrapperManager
     */
    protected $streamWrapperManager;

    function __construct(StreamWrapperManager $streamWrapperManager)
    {
        $this->streamWrapperManager = $streamWrapperManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $streamWrappers = [];
        foreach ($this->streamWrapperManager->getStreamWrappers() as $streamWrapper) {
            $streamWrappers[$streamWrapper->getScheme()] = $streamWrapper->getName();
        }

        $builder->add('defaultStreamWrapperScheme', 'choice', [
            'label'    => 'Default Stream Wrapper',
            'choices'  => $streamWrappers,
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
