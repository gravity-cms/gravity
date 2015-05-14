<?php

namespace Gravity\NodeBundle\Controller\Admin;

use Doctrine\ORM\EntityManager;
use Gravity\NodeBundle\Entity\Node;
use Gravity\NodeBundle\Form\NodeForm;
use Gravity\NodeBundle\Structure\Model\ContentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NodeController
 *
 * @package Gravity\NodeBundle\Controller\Admin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeController extends Controller
{
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em    = $this->getDoctrine()->getManager();
        $nodes = $em->getRepository('GravityNodeBundle:Node')->findAll();

        $contentTypes = $this->get('gravity_node.content_type_repository')->getContentTypes();

        return $this->render(
            'GravityNodeBundle:Node:index.html.twig',
            [
                'nodes'        => $nodes,
                'contentTypes' => $contentTypes,
            ]
        );
    }

    /**
     * @return Response
     */
    public function newSelectAction()
    {
        $contentTypes = $this->get('gravity_node.content_type_repository')->getContentTypes();

        return $this->render(
            'GravityNodeBundle:Node:new-select.html.twig',
            [
                'contentTypes' => $contentTypes,
            ]
        );
    }


    /**
     * @param string $type
     *
     * @throws NotFoundHttpException
     * @return Response
     */
    public function newAction($type)
    {
        /** @var ContentType $contentType */
        $contentType = $this->get('gravity_node.content_type_repository')->get($type);

        if (!$contentType instanceof ContentType) {
            throw $this->createNotFoundException('Content Type Not Found');
        }

        $node = new Node();
        $node->setContentType($contentType->getId());

        $form = $this->createForm(
            new NodeForm(),
            $node,
            [
                'attr'            => [
                    'class' => 'api-save'
                ],
                'csrf_protection' => false,
                'method'          => 'POST',
                'content_type'    => $contentType,
                'action'          => $this->generateUrl(
                    'gravity_api_post_node_type',
                    [
                        'contentType' => $contentType->getId()
                    ]
                ),
            ]
        );

        return $this->render(
            'GravityNodeBundle:Node:new.html.twig',
            [
                'editor'      => $this->get('gravity.editor'), // @TODO: make this dynamic
                'fields'      => $contentType->getFields(),
                'contentType' => $contentType,
                'form'        => $form->createView(),
            ]
        );
    }

    public function editAction(Node $node)
    {
        $fieldManager = $this->get('gravity_cms.field_manager');

        /** @var ContentType $contentType */
        $contentType = $this->get('gravity_node.content_type_repository')->get($node->getContentType());

        $form = $this->createForm(
            new NodeForm(),
            $node,
            [
                'content_type' => $contentType,
                'attr'         => [
                    'class' => 'api-save'
                ],
                'method'       => 'PUT',
                'action'       => $this->generateUrl(
                    'gravity_api_put_node',
                    [
                        'node' => $node->getId()
                    ]
                ),
            ]
        );

        return $this->render(
            'GravityNodeBundle:Node:edit.html.twig',
            [
                'editor' => $this->get('gravity.editor'), // @TODO: make this dynamic
                'fields' => $contentType->getFields(),
                'node'   => $node,
                'form'   => $form->createView(),
            ]
        );
    }


} 
