<?php


namespace Gravity\FileBundle\Form;

use Gravity\FileBundle\ImageStyler\ImageStyleManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageStyleOperationForm
 *
 * @package Gravity\FileBundle\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleOperationForm extends AbstractType
{
    /**
     * @var ImageStyleManager
     */
    protected $imageStyleManager;

    protected $imageOperationOptions = [];

    function __construct(ImageStyleManager $imageStyleManager)
    {
        $this->imageStyleManager = $imageStyleManager;

        foreach($this->imageStyleManager->getOperations() as $operation){
            $this->imageOperationOptions[$operation->getName()] = $operation->getLabel();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('name', 'config_name', [
                'target' => 'label'
            ])
            ->add('delta', 'hidden')
            ->add('type', 'choice', [
                'empty_value' => 'Select...',
                'choices' => $this->imageOperationOptions,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => '\Gravity\FileBundle\Entity\ImageStyleOperation'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'image_style_operation';
    }
}
