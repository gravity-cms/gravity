<?php

namespace Gravity\NodeBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class RoutingController
 *
 * @package Gravity\NodeBundle\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class RoutingController extends Controller
{
    public function settingsAction()
    {
        $configManager = $this->get('gravity_cms.configuration_manager');
        $config        = $configManager->get('routing.settings');

        $form = $this->createForm($config->getForm(), $config, array(
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_routing'),
            'attr' => array(
                'class' => 'api-save',
            ),
        ));

        return $this->render('GravityNodeBundle:Routing:tab-settings.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function routesAction()
    {
        return $this->render('GravityNodeBundle:Routing:tab-routes.html.twig');
    }


    public function manageAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        return $this->render('GravityNodeBundle:Routing:tab-manage.html.twig', array(

        ));
    }
} 
