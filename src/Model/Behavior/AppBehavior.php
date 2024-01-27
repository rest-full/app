<?php

namespace App\Model\Behavior;

use Restfull\Error\Exceptions;
use Restfull\ORM\Behavior\Behavior;

/**
 *
 */
class AppBehavior extends Behavior
{

    /**
     * @param string $method
     * @param array $options
     *
     * @return mixed
     * @throws Exceptions
     */
    public function methodActive(string $method, array $options)
    {
        $this->checkCallMethod($this, $method, $options);
        return $this->data;
    }

}
