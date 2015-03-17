<?php

namespace Gravity\NodeBundle\Entity;

use GravityCMS\Component\Entity\Entity\AbstractEntityField;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class NodeContent
 *
 * @package Gravity\NodeBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeContent extends AbstractEntityField
{
    /**
     * @var ContentTypeField
     */
    protected $contentTypeField;

    /**
     * @return ContentTypeField
     */
    public function getContentTypeField()
    {
        return $this->contentTypeField;
    }

    /**
     * @param ContentTypeField $fieldType
     */
    public function setContentTypeField(ContentTypeField $fieldType)
    {
        $this->contentTypeField = $fieldType;
    }
}
