<?php


namespace Gravity\CoreBundle\Field\Choice\Widget\Select\DataTransformer;

use Gravity\CoreBundle\Entity\FieldChoice;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class ChoiceArrayToStringDataTransformer
 *
 * @package Gravity\CoreBundle\Field\Choice\Widget\Select\DataTransformer
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ChoiceArrayToStringDataTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array to a string.
     * POSSIBLE LOSS OF DATA
     *
     * @param  FieldChoice $value
     *
     * @return string
     */
    public function transform($value)
    {
        if ($value instanceof FieldChoice) {
            $values = $value->getValues();
            if (count($values)) {
                $value->setValues($values[0]);
            } else {
                $value->setValues(null);
            }
        }

        return $value;
    }

    /**
     * Transforms a string to an array.
     *
     * @param  FieldChoice $value
     *
     * @return array
     */
    public function reverseTransform($value)
    {
        if ($value instanceof FieldChoice) {
            $values = $value->getValues();
            if (!is_array($values) && $values !== null) {
                $value->setValues([$values]);
            }
        }

        return $value;
    }
}
