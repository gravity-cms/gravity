<?php

namespace Gravity\CoreBundle\FosRest\View\View;

use FOS\RestBundle\View\View;

/**
 * Class JsonApiView
 *
 * @package Gravity\CoreBundle\FosRest\View\View
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class JsonApiView extends View {

    public function __construct($data = null, $statusCode = null, array $options = array(), array $headers = array())
    {
        parent::__construct($data, $statusCode, $headers);

        $this->setData(array(
            'data' => $this->getData(),
            'status' => $this->getStatusCode(),
            'options' => $options,
        ));
        $this->setStatusCode(200);
        $this->setHeader('X-NEFARIAN-API', 'true');
    }

}
