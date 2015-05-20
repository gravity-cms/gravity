<?php


namespace Gravity\CoreBundle\Field\Boolean\Widget\Select;

use Gravity\CoreBundle\Field\Choice\Widget\Select\SelectWidget as ChoiceSelectWidget;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SelectWidget
 *
 * @package gravity\CoreBundle\Field\Boolean\Widget\Select
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SelectWidget extends ChoiceSelectWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'boolean.select';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return new SelectWidgetForm();
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'expanded'     => false,
                'true_option'  => 'Yes',
                'false_option' => 'No',
            ]
        );
    }
}
