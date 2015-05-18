<?php

namespace Gravity\NodeBundle\Form;

use Gravity\CoreBundle\Entity\Field;

/**
 * Interface FieldNodeFormInterface
 *
 * @package Gravity\NodeBundle\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface FieldNodeFormInterface
{
    /**
     * @param Field $field
     */
    function __construct(Field $field);
} 
