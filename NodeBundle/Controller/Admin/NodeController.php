<?php

namespace Gravity\NodeBundle\Controller\Admin;

use Doctrine\ORM\EntityManager;
use Gravity\NodeBundle\Entity\ContentType;
use Gravity\NodeBundle\Entity\Node;
use Gravity\NodeBundle\Form\NodeForm;
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

        return $this->render('GravityNodeBundle:Node:index.html.twig', array(
            'nodes' => $nodes,
        ));
    }

    /**
     * @return Response
     */
    public function newSelectAction()
    {
        $em           = $this->getDoctrine()->getManager();
        $contentTypes = $em->getRepository('GravityNodeBundle:ContentType')->findAll();

        return $this->render('GravityNodeBundle:Node:new-select.html.twig', array(
            'contentTypes' => $contentTypes,
        ));
    }


    /**
     * @param $id
     *
     * @throws NotFoundHttpException
     * @return Response
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var ContentType $contentType */
        $contentType = $em->getRepository('GravityNodeBundle:ContentType')->find($id);

        if(!$contentType instanceof ContentType)
        {
            throw $this->createNotFoundException('Content Type Not Found');
        }

        $fieldManager = $this->get('gravity_cms.field_manager');
        $node         = new Node();
        $node->setContentType($contentType);

        $form = $this->createForm(new NodeForm($fieldManager), $node, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'POST',
            'action' => $this->generateUrl('gravity_api_post_node_type', array(
                    'contentType' => $contentType->getId()
                )),
        ));

        return $this->render('GravityNodeBundle:Node:new.html.twig', array(
            'editor' => $this->get('gravity.editor'), // @TODO: make this dynamic
            'fields'      => $fieldManager->getFields(),
            'contentType' => $contentType,
            'form'        => $form->createView(),
        ));
    }

    public function editAction(Node $node)
    {
        $fieldManager = $this->get('gravity_cms.field_manager');

        $form = $this->createForm(new NodeForm($fieldManager), $node, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_node', array(
                'node' => $node->getId()
            )),
        ));

        return $this->render('GravityNodeBundle:Node:edit.html.twig', array(
            'editor' => $this->get('gravity.editor'), // @TODO: make this dynamic
            'fields' => $fieldManager->getFields(),
            'node'   => $node,
            'form'   => $form->createView(),
        ));
    }


} 
