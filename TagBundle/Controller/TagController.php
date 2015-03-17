<?php

namespace Gravity\TagBundle\Controller;

use Gravity\TagBundle\Entity\Tag;
use Gravity\TagBundle\Form\TagForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TagController
 *
 * @package Gravity\TagBundle\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagController extends Controller
{
    public function indexAction()
    {
        $em   = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('GravityTagBundle:Tag')->findAllRootTags();

        return $this->render('GravityTagBundle:Tag:index.html.twig', [
            'tags' => $tags,
        ]);
    }


    /**
     * @param Tag $parentTag
     *
     * @return Response
     */
    public function newAction(Tag $parentTag = null)
    {
        $tag = new Tag();

        if ($parentTag instanceof Tag) {
            $tag->setParentTag($parentTag);
        }

        $form = $this->createForm(new TagForm(), $tag, [
            'attr'   => [
                'class' => 'api-save'
            ],
            'method' => 'POST',
            'action' => $this->generateUrl('gravity_api_post_tag'),
        ]);

        return $this->render('GravityTagBundle:Tag:new.html.twig', [
            'parentTag' => $parentTag,
            'form'      => $form->createView(),
        ]);
    }

    public function editAction(Tag $nodeTag)
    {
        $form = $this->createForm(new TagForm(), $nodeTag, [
            'attr'   => [
                'class' => 'api-save'
            ],
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_tag', [
                'id' => $nodeTag->getId()
            ]),
        ]);

        $em      = $this->getDoctrine()->getManager();
        $parents = $em->getRepository('GravityTagBundle:Tag')->findAllParentTags($nodeTag);

        return $this->render('GravityTagBundle:Tag:edit.html.twig', [
            'tag'     => $nodeTag,
            'parents' => $parents,
            'form'    => $form->createView(),
        ]);
    }


} 
