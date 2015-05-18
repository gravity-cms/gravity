<?php

namespace Gravity\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NodeController extends Controller
{
    public function listAction()
    {
        $themeManager = $this->get('gravity_cms.theme_manager');

        return $this->render('GravityCoreBundle:Theme:list.html.twig', array(
            'themes' => $themeManager->getThemes(),
        ));
    }

    public function newAction()
    {
        // TODO: create!
        return $this->render('GravityCoreBundle:Theme:new.html.twig');
    }
}
