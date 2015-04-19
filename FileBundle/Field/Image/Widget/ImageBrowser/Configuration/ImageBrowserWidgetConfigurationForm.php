<?php


namespace Gravity\FileBundle\Field\Image\Widget\ImageBrowser\Configuration;

use Doctrine\ORM\EntityManager;
use Gravity\FileBundle\ImageStyler\ImageStyleManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageBrowserWidgetConfigurationForm
 *
 * @package Gravity\FileBundle\Field\Image\Widget\ImageBrowser\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageBrowserWidgetConfigurationForm extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $imageStyleManager;

    protected $imageStyleOptions = [];

    function __construct(ImageStyleManager $imageStyleManager)
    {
        $this->imageStyleManager = $imageStyleManager;

        foreach($imageStyleManager->getImageStyles() as $imageStyle)
        {
            $this->imageStyleOptions[$imageStyle->getName()] = ucfirst($imageStyle->getName());
        }
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageStyle', 'choice', [
                'choices' => $this->imageStyleOptions
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_type' => 'Gravity\FileBundle\Entity\FieldImage'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_image_widget_image_browser_configuration';
    }

}
