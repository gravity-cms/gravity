<?php

namespace Gravity\TagBundle\Field\Widget\Form;

use Doctrine\ORM\EntityManager;
use Gravity\TagBundle\AutoComplete\TagAutoCompleteHandler;
use Gravity\TagBundle\Field\Configuration\FieldTagConfiguration;
use Gravity\NodeBundle\Entity\ContentTypeField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TagAutoCompleteWidgetForm
 *
 * @package Gravity\TagBundle\Field\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagAutoCompleteWidgetForm extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var TagAutoCompleteHandler
     */
    protected $handler;

    function __construct(EntityManager $em, TagAutoCompleteHandler $handler)
    {
        $this->em      = $em;
        $this->handler = $handler;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldTagConfiguration $configuration */
        /** @var ContentTypeField $typeField */
        $typeField     = $options['content_type_field'];
        $configuration = $typeField->getConfig();
        $limit         = $configuration->getLimit();

        $builder
            ->add('tags', 'auto_complete', [
                'handler'         => $this->handler,
                'multiple'        => $configuration->isMultiple(),
                'allow_new'       => $configuration->isAllowNew(),
                'handler_options' => [
                    'field' => $typeField->getId(),
                ],
                'limit'           => (int)$limit,
                'label'           => $limit == 1 ? null : $limit,
                'attr'            => [
                    'class' => 'form-control content-tags'
                ]
            ]);
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\TagBundle\Entity\FieldTag'
            ]
        );

        $resolver->setRequired(['content_type_field']);
        $resolver->setAllowedTypes([
            'content_type_field' => '\Gravity\NodeBundle\Entity\ContentTypeField',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tag_widget_autocomplete';
    }
}
