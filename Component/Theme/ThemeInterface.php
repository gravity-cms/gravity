<?php

namespace Gravity\Component\Theme;

interface ThemeInterface
{
    /**
     * Return the unique name of the theme
     *
     * @return string
     */
    public function getName();

    /**
     * The type of theme. Either self::TYPE_FRONTEND or self::TYPE_ADMIN
     *
     * @return int
     */
    public function getType();
} 
