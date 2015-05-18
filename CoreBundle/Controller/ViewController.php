<?php

namespace Gravity\CoreBundle\Controller;

use Doctrine\ORM\EntityManager;
use Gravity\CoreBundle\Entity\Block;
use Gravity\CoreBundle\Entity\Layout;
use Gravity\CoreBundle\Entity\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ViewController extends Controller
{
    public function listAction()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $views = $entityManager->getRepository('GravityCoreBundle:View')->findAll();

        return $this->render('GravityCoreBundle:Theme/View:list.html.twig', array(
            'views' => $views,
        ));
    }

    public function newAction()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $view = new View();
        $form = $this->createForm('gravity_cms_view', $view, array(
            'method' => 'POST',
            'action' => $this->generateUrl('gravity_api_post_view'),
            'attr'   => array(
                'class' => 'api-save',
            )
        ));

        return $this->render('GravityCoreBundle:Theme/View:new.html.twig', array(
            'form'      => $form->createView(),
        ));
    }

    public function editAction(Layout $layout)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();
        $positions     = $entityManager->getRepository('GravityCoreBundle:LayoutPosition')->findAll();
        $blocks        = $entityManager->getRepository('GravityCoreBundle:Block')->findAll();

        $form = $this->createForm('gravity_cms_layout', $layout, array(
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_layout', array(
                'id' => $layout->getId()
            )),
            'attr'   => array(
                'class' => 'api-save',
            )
        ));

        return $this->render('GravityCoreBundle:Theme/Layout:edit.html.twig', array(
            'layout'    => $layout,
            'positions' => $positions,
            'blocks'    => $blocks,
            'form'      => $form->createView(),
        ));
    }
}
