<?php

namespace Gravity\NodeBundle\Controller;

use Gravity\NodeBundle\Structure\Model\ContentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ContentTypeController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $contentTypeRepository = $this->get('gravity_node.content_type_repository');

        return $this->render(
            'GravityNodeBundle:ContentType:index.html.twig',
            [
                'contentTypes' => $contentTypeRepository->getContentTypes(),
            ]
        );
    }

    /**
     * @param string $type
     *
     * @return Response
     */
    public function viewAction($type)
    {
        $contentType = $this->get('gravity_node.content_type_repository')->get($type);

        if (!$contentType instanceof ContentType) {
            throw $this->createNotFoundException('Content Type not found');
        }

        return $this->render(
            'GravityNodeBundle:ContentType:view.html.twig',
            [
                'contentType' => $contentType,
            ]
        );
    }
} 
