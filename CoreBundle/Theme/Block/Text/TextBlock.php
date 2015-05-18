<?php

namespace Gravity\CoreBundle\Theme\Block\Text;

use Gravity\Component\Theme\Block\AbstractBlock;
use Gravity\CoreBundle\Form\Block\TextBlockForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TextBlock
 *
 * @package Gravity\CoreBundle\View\Block\Text
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextBlock extends AbstractBlock
{
    /**
     * Get the block type (the identifier for this block)
     *
     * @return string
     */
    public function getType()
    {
        return 'block.text';
    }

    /**
     * Get the block name
     *
     * @return string
     */
    public function getName()
    {
        return 'Text Block';
    }

    /**
     * Get the block description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Display a raw text field';
    }

    /**
     * Get the block's entity form
     *
     * @return string|AbstractType
     */
    public function getForm()
    {
        return new TextBlockForm();
    }

    /**
     * Fetch the template name
     *
     * @param Request $request
     * @param object  $entity
     *
     * @return string
     */
    public function render(Request $request, $entity)
    {
        // TODO: Implement render() method.
    }

}
