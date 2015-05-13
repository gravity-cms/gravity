<?php


namespace Gravity\NodeBundle\Structure\Model\Factory;

use Gravity\NodeBundle\Structure\Model\ContentType;
use GravityCMS\Component\Field\FieldManager;
use GravityCMS\Component\Field\Widget\WidgetReference;

/**
 * Class ContentTypeFactory
 *
 * @package Gravity\NodeBundle\Structure\Model\Factory
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ContentTypeFactory 
{
    public static function create(FieldManager $fieldManager, $id, array $contentTypeConfig){
        $contentType = new ContentType();
        $contentType->setId($id);
        $contentType->setName($contentTypeConfig['name']);
        $contentType->setDescription($contentTypeConfig['description']);

        $fields = [];
        foreach ($contentTypeConfig['fields'] as $fieldConfig) {
            $field = $fieldManager->getField($fieldConfig['type']);

            $fieldConfiguration = $field->getSettings();
            $fieldConfiguration->
            $fieldWidget = $fieldManager->getFieldWidget($fieldConfig['widget']['type']);
            new WidgetReference(
                $field,
                $fieldConfig['settings'],
                $fieldWidget,
                $fieldConfig['widget']['settings']
            );
        }
        $contentType->setFields($fields);

        return $contentType;
    }
}
