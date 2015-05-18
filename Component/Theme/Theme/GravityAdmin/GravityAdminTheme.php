<?php

namespace Gravity\Component\Theme\Theme\GravityAdmin;

use Gravity\Component\Theme\AbstractTheme;

/**
 * Class GravityAdminTheme
 *
 * @package Gravity\Component\Theme\Theme\GravityAdmin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class GravityAdminTheme extends AbstractTheme
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'gravity_admin';
    }

    public function getLabel()
    {
        return 'Gravity Theme';
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return self::TYPE_ADMIN;
    }
} 
