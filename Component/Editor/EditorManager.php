<?php

namespace Gravity\Component\Editor;

/**
 * Class EditorManager
 *
 * @package Gravity\Component\Editor
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class EditorManager
{
    protected $editors = array();

    /**
     * @param array $editors
     */
    public function setEditors(array $editors)
    {
        foreach($editors as $editor)
        {
            $this->addEditor($editor);
        }
    }

    public function addEditor(EditorInterface $editor)
    {
        $this->editors[$editor->getName()] = $editor;
    }

    public function getEditor($name)
    {
        return $this->editors[$name];
    }

    /**
     * @return array
     */
    public function getEditors()
    {
        return $this->editors;
    }


} 
