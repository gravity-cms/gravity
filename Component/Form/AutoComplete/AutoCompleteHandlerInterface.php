<?php

namespace Gravity\Component\Form\AutoComplete;

/**
 * Interface AutoCompleteHandlerInterface
 *
 * @package Gravity\Component\Form\AutoComplete
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface AutoCompleteHandlerInterface
{
    /**
     * Return the data class name
     *
     * @return string
     */
    public function getDataClass();

    /**
     * Return the data property name
     *
     * @return string
     */
    public function getDataProperty();

    /**
     * Given a search term, return a set of entities
     *
     * @param string $term
     * @param array  $options
     *
     * @return array
     */
    public function getOptions($term, array $options = array());

    /**
     * @param array $ids
     * @param array $options
     *
     * @return \object[]
     */
    public function getObjects(array $ids = array(), array $options = array());

    /**
     * Get a unique name for the handler
     *
     * @return string
     */
    public function getName();
}
