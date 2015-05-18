<?php

namespace Gravity\Component\Theme\View;

/**
 * Class ViewManager
 *
 * @package Gravity\Component\Theme\View
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ViewManager
{
    /**
     * @var ViewInterface[]
     */
    protected $views = array();

    /**
     * @return ViewInterface[]
     */
    public function getViews()
    {
        return $this->views;
    }

    public function getView($name)
    {
        foreach($this->views as $view)
        {
            if($view->getName() === $name)
            {
                return $view;
            }
        }
    }

    /**
     * @param ViewInterface[] $views
     */
    public function setViews($views)
    {
        $this->views = $views;
    }
}
