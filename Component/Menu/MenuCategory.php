<?php

namespace Gravity\Component\Menu;

class MenuCategory
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @var array
     */
    protected $links = array();

    /**
     * @param $name
     * @param $title
     * @param $icon
     * @param $description
     */
    function __construct($name, $title, $icon, $description='')
    {
        $this->name        = $name;
        $this->title       = $title;
        $this->description = $description;
        $this->icon        = $icon;
    }

    /**
     * @param $link
     */
    public function addLink($link)
    {
        $this->links[] = array(
            'title'       => $link['title'],
            'route'       => $link['route'],
            'description' => $link['description'],
        );
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param array $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


} 
