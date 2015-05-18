<?php

namespace Gravity\CoreBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\Form\AbstractType;

/**
 * Class LayoutBlockController
 *
 * @package Gravity\Component\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @FOSRest\RouteResource("layout/block")
 */
class LayoutBlockController extends AbstractApiController
{
    /**
     * Get the form type
     *
     * @return AbstractType
     */
    function getForm()
    {
        return $this->get('gravity_cms.theme.form.layout_block');
    }

    /**
     * Get the entity name
     *
     * @return string
     */
    function getEntityClass()
    {
        return '\Gravity\Component\Entity\Entity\View';
    }

    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch ($method) {
            case self::METHOD_VIEW_ALL:
                return $this->generateUrl('gravity_admin_layout_list');
                break;

            case self::METHOD_POST:
                return $this->generateUrl('gravity_api_post_block');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('gravity_api_put_block', array('id' => $entity->getId()));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('gravity_api_delete_block',
                    array('id' => $entity->getId()));
                break;

            case self::METHOD_GET:
                return '';
                return $this->generateUrl('gravity_admin_content_type_edit',
                    array('type' => $entity->getName()));
                break;
        }

        return '';
    }

    function hasPermission($method)
    {
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

//    public function getTableResultsAction(Request $request)
//    {
//        /**
//         * @var \Sg\DatatablesBundle\Datatable\Data\DatatableData $datatable
//         */
//
//        $dataTableManager = $this->get('nefarian.datatable_manager');
//
//        $dataTable = new ViewDataTableType($this->container->get('router'));
//        $response = $dataTableManager->create($dataTable, $request);
//
//        return new JsonResponse($response);
//    }

}
