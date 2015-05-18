<?php
/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */

namespace Gravity\Component\Theme\Layout\Configuration;


use Gravity\Component\Configuration\Form\ConfigurationSettingsForm;
use Symfony\Component\Form\FormBuilderInterface;

class LayoutConfigurationForm extends ConfigurationSettingsForm
{
    protected function buildConfigForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'configuration_layout';
    }

}
