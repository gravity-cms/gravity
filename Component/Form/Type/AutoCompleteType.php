<?php

namespace Gravity\Component\Form\Type;

use Gravity\Component\Form\AutoComplete\AutoCompleteHandlerInterface;
use Gravity\Component\Form\AutoComplete\AutoCompleteManager;
use Gravity\Component\Form\DataTransformer\AutoCompleteTransformer;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutoCompleteType extends AbstractType
{
    /**
     * @var AutoCompleteManager
     */
    protected $autoCompleteManager;

    /**
     * @var Router
     */
    protected $router;

    function __construct(AutoCompleteManager $autoCompleteManager, Router $router)
    {
        $this->autoCompleteManager = $autoCompleteManager;
        $this->router              = $router;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'limit'           => null,
                'name'            => null,
                'allow_new'       => false,
                'handler_options' => [],
                'multiple'        => true,
            ])
            ->setRequired([
                'handler',
            ])
            ->setAllowedTypes([
                'handler'         => '\Gravity\Component\Form\AutoComplete\AutoCompleteHandlerInterface',
                'limit'           => 'integer',
                'allow_new'       => 'bool',
                'handler_options' => 'array',
                'multiple'        => 'bool',
            ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer =
            new AutoCompleteTransformer($options['handler'], $options['handler_options'], $options['allow_new']);

        $builder->addModelTransformer($transformer);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /** @var AutoCompleteHandlerInterface $handler */
        $handler = $options['handler'];

        $view->vars['attr']['data-multiple'] = $options['multiple'] ? 1 : 0;
        $view->vars['attr']['data-allow-new'] = $options['allow_new'] ? 1 : 0;
        $view->vars['attr']['data-url']      = $this->router->generate('gravity_cms_form_autocomplete', [
            'type'    => $handler->getName(),
            'options' => $options['handler_options'],
        ]);

        if ($options['limit'] !== null || $options['limit'] > 0) {
            $view->vars['attr']['data-limit'] = $options['limit'];
        }
    }


    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'auto_complete';
    }
}
