<?php

namespace Gravity\Component\Configuration\Form;

use Gravity\Component\Configuration\ConfigurationInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class ConfigurationSettingsForm
 *
 * @package Gravity\Component\Configuration\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class ConfigurationSettingsForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $data = $event->getData();
            $form = $event->getForm();

            if($data instanceof ConfigurationInterface)
            {
                if(!$data->getConfigurationName())
                {
                    $form->add('configurationName', 'text', array(
                        'label' => 'Machine Name'
                    ));
                }
            }
        });

        $this->buildConfigForm($builder, $options);
    }

    abstract protected function buildConfigForm(FormBuilderInterface $builder, array $options);
}
