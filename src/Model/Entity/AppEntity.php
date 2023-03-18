<?php

namespace App\Model\Entity;

use Restfull\ORM\Entity\Entity;
use Restfull\ORM\TableRegistry;

/**
 * Class AppEntity
 *
 * @package App\Model\Entity
 */
class AppEntity extends Entity
{

    /**
     * AppEntity constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (count($config) > 0) {
            $type = $config['type'];
            unset($config['type']);
            $nameTable = $config['table'];
            unset($config['table']);
            if (isset($config['repository'])) {
                $this->repository($config['repository']);
                unset($config['repository']);
            }
            $this->config($type, $nameTable, $config);
            $this->entity();
            if (isset($this->repository)) {
                unset($this->repository);
            }
            return $this;
        }
        return $this;
    }

    /**
     * @param TableRegistry $tableRegistry
     *
     * @return AppEntity
     */
    public function repository(TableRegistry $tableRegistry): AppEntity
    {
        $this->repository = $tableRegistry;
        return $this;
    }
}