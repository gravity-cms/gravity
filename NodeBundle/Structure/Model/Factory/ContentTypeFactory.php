<?php


namespace Gravity\NodeBundle\Structure\Model\Factory;

use Gravity\NodeBundle\Structure\Model\ContentType;
use Gravity\Component\Field\FieldManager;
use Gravity\Component\Field\Widget\WidgetReference;

/**
 * Class ContentTypeFactory
 *
 * @package Gravity\NodeBundle\Structure\Model\Factory
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentTypeFactory
{
    /**
     * @param FieldManager $fieldManager
     * @param              $id
     * @param array        $contentTypeConfig
     *
     * @return ContentType
     * @throws \Exception
     */
    public static function create(FieldManager $fieldManager, $id, array $contentTypeConfig)
    {
        $contentType = new ContentType();
        $contentType->setId($id);
        $contentType->setName($contentTypeConfig['name']);
        $contentType->setDescription($contentTypeConfig['description']);

        $fields = [];
        foreach ($contentTypeConfig['fields'] as $fieldName => $fieldConfig) {

            $fields[] = $fieldDefinition = $fieldManager->getField($fieldConfig['type'], $fieldName);

            $fieldWidget = new WidgetReference(
                $fieldManager->getFieldWidget($fieldConfig['widget']['type']),
                $fieldConfig['widget']['settings']
            );
            $fieldDefinition->setWidget($fieldWidget);
        }
        $contentType->setFields($fields);

        return $contentType;
    }
}
