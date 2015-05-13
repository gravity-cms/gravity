<?php


namespace Gravity\NodeBundle\Structure\Repository;

use Gravity\NodeBundle\Structure\Model\ContentType;

/**
 * Class ContentTypeRepository
 *
 * @package Gravity\NodeBundle\Structure\Repository
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ContentTypeRepository 
{
    /**
     * @var ContentType[]
     */
    protected $contentTypes = [];

    /**
     * @return ContentType[]
     */
    public function getContentTypes()
    {
        return $this->contentTypes;
    }

    /**
     * @param ContentType[] $contentTypes
     */
    public function setContentTypes(array $contentTypes)
    {
        $this->contentTypes = $contentTypes;
    }

    /**
     * @param ContentType $contentType
     */
    public function addContentType($contentType)
    {
        $this->contentTypes[] = $contentType;
    }
}
