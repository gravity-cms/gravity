<?php

namespace Gravity\Component\Form\AutoComplete;

use Doctrine\ORM\EntityManager;

/**
 * Class SimpleAutoCompleteHandler
 *
 * @package Gravity\Component\Form\AutoComplete
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SimpleAutoCompleteHandler extends AbstractAutoCompleteHandler
{
    function __construct(EntityManager $entityManager, $dataClass, $dataProperty, $searchType = self::SEARCH_TYPE_CONTAINS)
    {
        $this->entityManager = $entityManager;
        $this->dataClass     = $dataClass;
        $this->dataProperty  = $dataProperty;
        $this->searchType    = $searchType;
    }

    /**
     * Get a unique name for the handler
     *
     * @return string
     */
    public function getName()
    {
        return 'auto_complete.simple.' . sha1($this->dataClass . $this->dataProperty);
    }
}
