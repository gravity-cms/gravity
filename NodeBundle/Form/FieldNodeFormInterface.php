<?php

namespace Gravity\NodeBundle\Form;

use Gravity\NodeBundle\Entity\ContentTypeField;

/**
 * Interface FieldNodeFormInterface
 *
 * @package Gravity\NodeBundle\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface FieldNodeFormInterface
{
    /**
     * @param ContentTypeField $field
     */
    function __construct(ContentTypeField $field);
} 
