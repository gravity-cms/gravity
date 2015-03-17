<?php

namespace Gravity\NodeBundle\Controller;

use Gravity\NodeBundle\Entity\ContentType;
use Gravity\NodeBundle\Entity\Node;
use Gravity\NodeBundle\Form\NodeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NodeController
 *
 * @package Gravity\NodeBundle\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeController extends Controller
{
    public function viewAction(Node $node)
    {
        return $this->render('GravityNodeBundle:Node:view.html.twig', array(
            'node' => $node,
        ));
    }
} 
