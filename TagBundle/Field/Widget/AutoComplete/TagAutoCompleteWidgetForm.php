<?php

namespace Gravity\TagBundle\Field\Widget\AutoComplete;

use Doctrine\ORM\EntityManager;
use Gravity\TagBundle\AutoComplete\TagAutoCompleteHandler;
use Gravity\TagBundle\Field\Configuration\FieldTagConfiguration;
use GravityCMS\CoreBundle\Entity\Field;
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

    /**
     * @param EntityManager          $em
     * @param TagAutoCompleteHandler $handler
     */
    function __construct(EntityManager $em, TagAutoCompleteHandler $handler)
    {
        $this->em      = $em;
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldTagConfiguration $configuration */
        /** @var Field $field */
        $field         = $options['field'];
        $configuration = $field->getConfig();
        $limit         = $configuration->getLimit();

        $builder
            ->add('tags', 'auto_complete', [
                'handler'         => $this->handler,
                'multiple'        => $configuration->isMultiple(),
                'allow_new'       => $configuration->isAllowNew(),
                'handler_options' => [
                    'field' => $field->getId(),
                ],
                'limit'           => (int)$limit,
                'label'           => $limit == 1 ? null : $limit,
                'attr'            => [
                    'class' => 'form-control content-tags'
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\TagBundle\Entity\FieldTag'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_tag_widget_autocomplete';
    }
}
