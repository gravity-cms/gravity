<?php

namespace Gravity\Component\Menu;

class MenuManager
{

    /**
     * @var array
     */
    protected $links = array();

    /**
     * @var MenuCategory[]
     */
    protected $categories = array();

    /**
     * @param string $id
     * @param string $plugin
     * @param string $title
     * @param string $icon
     * @param string $description
     * @param array  $links
     *
     * @return MenuCategory
     */
    public function createCategory($id, $plugin, $title, $icon, $description = '', array $links = array())
    {
        $this->categories[$id] = $category = new MenuCategory($id, $title, $icon, $description);

        foreach($links as $link)
        {
            $category->addLink($link);
        }

        return $this->categories[$id];
    }

    public function addCategory(MenuCategory $menuCategory)
    {
        $this->categories[$menuCategory->getName()] = $menuCategory->getName();
    }

    /**
     * @param string $name
     *
     * @return MenuCategory
     */
    public function getCategory($name)
    {
        if(array_key_exists($name, $this->categories))
        {
            return $this->categories[$name];
        }
    }

    /**
     * @return MenuCategory[]
     */
    public function getCategories()
    {
        return $this->categories;
    }


    /**
     * Add a link to the link stack
     *
     * @param MenuCategory $category
     * @param string       $title
     * @param string       $route
     * @param string       $description
     */
    public function addLink(MenuCategory $category, $title, $route, $description = '')
    {
        $this->links[$category->getName()][] = array(
            'title'       => $title,
            'route'       => $route,
            'description' => $description,
        );
    }

    /**
     * Get all the links
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Get all the links
     *
     * @param MenuCategory $category
     *
     * @return array
     */
    public function getCategoryLinks(MenuCategory $category)
    {
        return $this->links[$category->getName()];
    }

} 
