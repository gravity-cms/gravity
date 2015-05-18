<?php

namespace Gravity\CoreBundle\Controller\Api;

use Gravity\Component\Theme\View\DataTable\ViewDataTableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ViewController
 *
 * @package Gravity\Component\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ViewController extends AbstractApiController
{
    /**
     * Get the form type
     *
     * @return AbstractType
     */
    function getForm()
    {
        return $this->get('gravity_cms.form.view');
    }

    /**
     * Get the entity name
     *
     * @return string
     */
    function getEntityClass()
    {
        return '\Gravity\CoreBundle\Entity\View';
    }

    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch($method)
        {
            case self::METHOD_VIEW_ALL:
                return $this->generateUrl('gravity_admin_content_type_manage');
                break;

            case self::METHOD_POST:
                return $this->generateUrl('gravity_api_post_type');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('gravity_api_put_type', array( 'id' => $entity->getId() ));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('gravity_api_delete_type', array( 'contentType' => $entity->getId() ));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('gravity_admin_content_type_edit', array( 'type' => $entity->getName() ));
                break;
        }

        return '';
    }

    function hasPermission($method)
    {
        return true;
        $userManager = $this->get('nefarian_core.user_manager');
        switch($method)
        {
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

    public function getTableResultsAction(Request $request)
    {
        /**
         * @var \Sg\DatatablesBundle\Datatable\Data\DatatableData $datatable
         */

        $dataTableManager = $this->get('nefarian.datatable_manager');

        $dataTable = new ViewDataTableType($this->container->get('router'));
        $response = $dataTableManager->create($dataTable, $request);

        return new JsonResponse($response);
    }

}
