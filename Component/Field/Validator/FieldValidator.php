<?php


namespace Gravity\Component\Field\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class FieldValidator
 *
 * @package Gravity\Component\Field\Validator
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class FieldValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        /** @var Constraint[] $fieldConstraints */
        $fieldConstraintList = $constraint->fields;
        $context = $this->context;
        foreach($fieldConstraintList as $field => $fieldConstraints){
            if ($context instanceof ExecutionContextInterface) {
                $validator = $context->getValidator()
                    ->inContext($context)
                    ->atPath($field);
                $validator->validate($value->{"get".$field}(), $fieldConstraints);
            } else {
                // 2.4 API
                $context->validateValue($value->{"get".$field}(), $fieldConstraints, '[' . $field . ']');
            }
        }
    }
}
