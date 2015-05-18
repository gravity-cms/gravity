<?php

namespace Gravity\Component\Theme\View;

use Gravity\Component\Theme\Block\BlockManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractView
 *
 * @package Gravity\Component\View
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractView implements ViewInterface
{
    /**
     * @var BlockManager
     */
    protected $blockManager;

    public function setBlockManager(BlockManager $blockManager)
    {
        $this->blockManager = $blockManager;
    }

    /**
     * Handle a request, return a response
     *
     * @param Request $request Request Object
     * @param object  $entity  Entity Object
     *
     * @return mixed
     */
    public function handle(Request $request, $entity)
    {
        $blocks = $this->blockManager->getBlocksForView($this);

        foreach($blocks as $block)
        {
            $block->render($request, $entity);
        }

    }

    /**
     * Handle a request to list an entity
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function handleList(Request $request)
    {
        $blocks = $this->blockManager->getBlocksForView($this);

        foreach($blocks as $block)
        {

        }
    }

    /**
     * Get a list of zone names for this view
     *
     * @return array
     */
    public function getZones()
    {
        return array(
            'body'
        );
    }
}
