<?php


namespace Gravity\NodeBundle\Structure\Model\Factory;

use Gravity\NodeBundle\Structure\Model\ContentType;
use GravityCMS\Component\Field\FieldManager;
use GravityCMS\Component\Field\Widget\WidgetReference;

/**
 * Class ContentTypeFactory
 *
 * @package Gravity\NodeBundle\Structure\Model\Factory
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentTypeFactory
{
    public static function create(FieldManager $fieldManager, $id, array $contentTypeConfig)
    {
        $contentType = new ContentType();
        $contentType->setId($id);
        $contentType->setName($contentTypeConfig['name']);
        $contentType->setDescription($contentTypeConfig['description']);

        $fields = [];
        foreach ($contentTypeConfig['fields'] as $fieldName => $fieldConfig) {

            $fields[] = $fieldDefinition = $fieldManager->createField(
                $fieldConfig['type'],
                $fieldName,
                $fieldConfig['settings']
            );

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
