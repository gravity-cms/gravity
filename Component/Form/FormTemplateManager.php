<?php

namespace Gravity\Component\Form;

/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class FormTemplateManager
{
    protected $templates = array();

    public function addTemplate($template)
    {
        $this->templates[] = $template;
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        return $this->templates;
    }
} 
