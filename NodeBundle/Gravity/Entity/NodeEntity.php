<?php
/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */

namespace Gravity\NodeBundle\Gravity\Entity;

use Gravity\Component\Entity\Definition\EntityDefinitionInterface;

class NodeEntity implements EntityDefinitionInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Node';
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return 'User generated content entity';
    }

    public function getListController()
    {
        // TODO: Implement getListController() method.
    }

    public function getDisplayController()
    {
        // TODO: Implement getDisplayController() method.
    }

}
