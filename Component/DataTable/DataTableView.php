<?php

namespace Gravity\Component\DataTable;

/**
 * Class DataTableView
 *
 * @package Gravity\Component\DataTable
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class DataTableView
{
    protected $columns = array();

    protected $options = array();

    protected $data = array();

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }


}
