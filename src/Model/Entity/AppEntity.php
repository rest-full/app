<?php

namespace App\Model\Entity;

use Restfull\Container\Instances;
use Restfull\ORM\Entity\BaseEntity;

/**
 * Class AppEntity
 *
 * @package App\Model\AppEntity
 */
class AppEntity extends BaseEntity
{

    /**
     * @param Instances $instance
     * @param array $options
     */
    public function __construct(Instances $instance, array $options = [])
    {
        if (count($options) > 0) {
            $config['repository'] = $options['repository'];
            unset($options['repository']);
            parent::__construct($instance, $config, $options);
        }
        return $this;
    }
}