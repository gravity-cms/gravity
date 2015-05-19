<?php


namespace Gravity\Component\Field\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class FieldConstraint
 *
 * @package Gravity\Component\Field\Validator
 * @author Andy Thorne <contrabandvr@gmail.com>
 *
 * @Annotation
 */
class Field extends Constraint
{
    public $message = 'The value is not a valid field';

    public $fields = [];

    public function getRequiredOptions()
    {
        return [
            'fields'
        ];
    }
}
