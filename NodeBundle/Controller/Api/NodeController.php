<?php

namespace Gravity\NodeBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use GravityCMS\CoreBundle\Controller\Api\AbstractApiController;
use GravityCMS\CoreBundle\Controller\Api\ApiControllerInterface;
use GravityCMS\CoreBundle\FosRest\View\View\JsonApiView;
use Gravity\NodeBundle\Entity\ContentType;
use Gravity\NodeBundle\Entity\Node;
use Gravity\NodeBundle\Form\NodeForm;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ContentTypeController
 *
 * @package Gravity\NodeBundle\Controller\Api
 *
 * @FOSRest\RouteResource("Node")
 */
class NodeController extends AbstractApiController implements ClassResourceInterface, ApiControllerInterface
{

    /**
     * Configure the query builder
     *
     * @param QueryBuilder $qb
     *
     * @return mixed
     */
    function setupQueryBuilder(QueryBuilder $qb)
    {
    }

    /**
     * Get the template for the form
     *
     * @param $method
     *
     * @return string
     */
    function getFormTemplate($method)
    {
        return '@theme/Api/form.html.twig';
    }

    /**
     * @return Form
     */
    function getForm()
    {
        return new NodeForm($this->get('gravity_cms.field_manager'));
    }

    /**
     * @return string
     */
    function getEntityClass()
    {
        return 'Gravity\NodeBundle\Entity\Node';
    }

    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch ($method) {
            case self::METHOD_VIEW_ALL:
                return $this->generateUrl('gravity_admin_content_type_manage');
                break;

            case self::METHOD_POST:
                return $this->generateUrl('gravity_api_post_node_type');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('gravity_api_put_node', array('id' => $entity->getId()));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('gravity_api_delete_node',
                    array('id' => $entity->getId()));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('gravity_admin_node_edit',
                    array('id' => $entity->getId()));
                break;
        }

        return '';
    }

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

    /**
     * @param Request     $request
     * @param ContentType $contentType
     *
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     * @return Response
     */
    public function postTypeAction(Request $request, ContentType $contentType)
    {
        $this->authenticate(self::METHOD_POST);

        if (!$contentType instanceof ContentType) {
            throw $this->createNotFoundException('Content Type Not Found');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $payload = json_decode($request->getContent(), true);

        $class = $this->getEntityClass();

        /** @var Node $newEntity */
        $newEntity = new $class();
        $newEntity->setContentType($contentType);
        $formType = new NodeForm($this->get('gravity_cms.field_manager'), $contentType);
        $form     = $this->createForm($formType, $newEntity);
        $form->submit($payload[$formType->getName()]);

        if ($form->isValid()) {
            /** @var Node $entity */
            $entity = $form->getData();
            $em->persist($entity);
            $em->flush();

            $view = JsonApiView::create($entity, 200, array(
                'location' => $this->getUrl(self::METHOD_GET, $entity)
            ));
        } else {
            $view = JsonApiView::create($form);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

} 
