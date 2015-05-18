<?php

namespace Gravity\Component\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

abstract class GravityBundle extends Bundle
{
    /**
     * @return string
     */
    abstract public function getGravityBundleName();
}
