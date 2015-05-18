<?php
/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */

namespace Gravity\Component\Theme\Form;


use Gravity\Component\Theme\Block\BlockManager;
use Gravity\Component\Theme\Layout\LayoutManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LayoutBlockForm extends AbstractType
{
    protected $positionOptions = array();
    protected $blockOptions = array();

    function __construct(BlockManager $blockManager)
    {
        $blocks = $blockManager->getBlocks();
        foreach($blocks as $block)
        {
            $this->blockOptions[$block->getName()] = $block->getName();
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('block', 'choice', array(
                'choices' => $this->blockOptions
            ))
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'gravity_cms_layout_block';
    }

}
