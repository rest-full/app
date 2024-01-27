<?php

namespace App\Model\Table;

use Restfull\Error\Exceptions;
use Restfull\ORM\Assembly;
use Restfull\ORM\BaseTable;

/**
 *
 */
class AppTable extends BaseTable
{

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $columnType = [];

    /**
     * @var string
     */
    private $table = '';

    /**
     * @var array
     */
    private $datas = [];

    /**
     * @var string
     */
    private $ids = '';

    /**
     * @var bool
     */
    private $return = false;

    /**
     *
     */
    public function __construct(BaseTable $baseTable, string $table)
    {
        foreach ($baseTable as $key => $value) {
            $this->{$key} = $value;
        }
        foreach ($this->tableRegistory->columns[$table] as $values) {
            $this->attributes[$table][] = $values['name'];
            $this->columnType[$table][] = $values['type'];
        }
        $this->table = $table;
        $this->ids = explode(', ', $this->tableRegistory->name);
        return $this;
    }

    /**
     * @return AppTable
     * @throws Exceptions
     */
    public function attributes(): AppTable
    {
        $newDatas = $this->query->getData();
        foreach (['nested', 'union'] as $key) {
            if (isset($newDatas[$key])) {
                unset($newDatas[$key]);
            }
        }
        $count = count($newDatas);
        for ($a = 0; $a < $count; $a++) {
            foreach (['fields', 'conditions'] as $key) {
                if (!isset($newDatas[$a][$key])) {
                    $newDatas[$a][$key] = [];
                }
            }
            if ($newDatas[$a]['table']['table'] === $this->table) {
                $table = $newDatas[$a]['table']['table'];
                $this->datas[$table] = $this->thereIsThisColumnForCreateOrChangeTheTable(
                    ['fields' => $newDatas[$a]['fields'], 'conditions' => $newDatas[$a]['conditions']],
                    $this->attributes[$table],
                    $table
                );
            }
        }
        return $this->changeTheDatasOptionsToFormTheQuery();
    }

    /**
     * @return AppTable
     * @throws Exceptions
     */
    private function changeTheDatasOptionsToFormTheQuery(): AppTable
    {
        $this->convertDatas();
        $aligns = false;
        if (count($this->datas[$this->table]) > 0) {
            list($aligns, $datas) = $this->changeds($aligns);
        }
        if ($aligns) {
            $this->query->setData($datas);
            $this->return = $aligns;
        }
        return $this;
    }

    /**
     * @param bool $aligns
     *
     * @return array
     */
    private function changeds(bool $aligns): array
    {
        $type = 'conditions';
        if ($this->typeExecuteQuery === 'update') {
            $type = 'fields';
        }
        $values = $this->datas[array_search($this->table, $this->ids)][$type];
        if ($type === 'conditions') {
            $existOperation = false;
            $operations = [];
            foreach (array_keys($values) as $operation) {
                if (in_array($operation, ['and', 'or']) !== false) {
                    if (!$existOperation) {
                        $existOperation = !$existOperation;
                    }
                    $operations[] = $operation;
                }
            }
        }
        foreach ($this->datas[$this->table] as $key => $value) {
            if ($type === 'conditions') {
                if ($existOperation) {
                    foreach ($operations as $operation) {
                        if ($value != $values[$operation][$key]) {
                            $this->datas[array_search($this->table, $this->ids)][$type][$operation][$key] = $value;
                            if (!$aligns) {
                                $aligns = !$aligns;
                            }
                        }
                    }
                } else {
                    if (in_array($key, array_keys($values)) !== false) {
                        if ($value != $values[$key]) {
                            $this->datas[array_search($this->table, $this->ids)][$type][$key] = $value;
                            if (!$aligns) {
                                $aligns = !$aligns;
                            }
                        }
                    }
                }
            } else {
                if (in_array($key, array_keys($values)) !== false) {
                    if ($value != $values[$key]) {
                        $this->datas[array_search($this->table, $this->ids)][$type][$key] = $value;
                        if (!$aligns) {
                            $aligns = !$aligns;
                        }
                    }
                }
            }
        }
        return [$aligns];
    }

    /**
     * @param array $datas
     *
     * @return array
     * @throws Exceptions
     */
    private function convertDatas(array $datas = []): array
    {
        $optionsDatas = $this->query->getData();
        $methods = $this->instance->methods($this->instance->name($this));
        foreach ($this->attribute[$this->table] as $value) {
            $key = $value;
            if (stripos($value, '.') !== false) {
                $value = substr($value, stripos($value, '.') + 1);
            }
            if (stripos($value, ' as ') !== false) {
                $value = substr($value, 0, stripos($value, ' as '));
            }
            if (in_array($key, $methods) !== false) {
                if (isset($this->datas[array_search($this->table, $this->ids)][array_search($value, $optionsDatas)])) {
                    $this->datas[array_search($this->table, $this->ids)][array_search(
                        $value,
                        $optionsDatas
                    )] = $this->{$value}(
                        $this->datas[array_search($this->table, $this->ids)][array_search($value, $optionsDatas)]
                    );
                }
            }
        }
        return $this;
    }
}
