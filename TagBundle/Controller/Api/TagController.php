<?php

namespace Gravity\TagBundle\Controller\Api;

use Gravity\TagBundle\Form\TagForm;
use GravityCMS\CoreBundle\Controller\Api\AbstractApiController;
use Symfony\Component\Form\AbstractType;

/**
 * Class TagController
 *
 * @package Gravity\TagBundle\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagController extends AbstractApiController
{
    /**
     * Get the form type
     *
     * @return AbstractType
     */
    function getForm()
    {
        return new TagForm();
    }

    /**
     * Get the entity name
     *
     * @return string
     */
    function getEntityClass()
    {
        return 'Gravity\TagBundle\Entity\Tag';
    }

    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch ($method) {
            case self::METHOD_POST:
                return $this->generateUrl('gravity_api_post_tag');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('gravity_api_put_tag', ['id' => $entity->getId()]);
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('gravity_api_delete_tag', ['id' => $entity->getId()]);
                break;

            case self::METHOD_GET:
                return $this->generateUrl('gravity_admin_tag_edit', ['id' => $entity->getId()]);
                break;
        }

        return '';
    }

    /**
     * @inheritdoc
     */
    function hasPermission($method)
    {
        return true;
        $userManager = $this->get('nefarian_core.user_manager');
        switch ($method) {
            case self::METHOD_NEW:
            case self::METHOD_POST:
                return $userManager->hasPermission($this->getUser(), 'content.type.create');
                break;

            case self::METHOD_EDIT:
            case self::METHOD_PUT:
                return $userManager->hasPermission($this->getUser(), 'content.type.update');
                break;

            case self::METHOD_DELETE:
                return $userManager->hasPermission($this->getUser(), 'content.type.delete');
                break;

            case self::METHOD_GET:
                return $userManager->hasPermission($this->getUser(), 'content.type.get');
                break;
        }

        return false;
    }

} 
