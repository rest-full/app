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
    private $data = [];

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
     * @return bool
     */
    public function validReturnAssembly(): bool
    {
        return $this->return;
    }

    /**
     * @return Assembly
     */
    public function returnQuery(): Assembly
    {
        return $this->query;
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
                $this->data[$table]
                    = $this->thereIsThisColumnForCreateOrChangeTheTable(
                    [
                        'fields' => $newDatas[$a]['fields'],
                        'conditions' => $newDatas[$a]['conditions']
                    ],
                    $this->attributes[$table],
                    $table
                );
            }
        }
        return $this;
    }

    /**
     * @param string $class
     *
     * @return AppTable
     */
    public function convertQuery(string $class): AppTable
    {
        $values = [];
        foreach (array_keys($this->data[$this->table]) as $value) {
            $key = $value;
            if (stripos($value, '.') !== false) {
                $value = substr($value, stripos($value, '.') + 1);
                if (stripos($value, ' ') !== false) {
                    $value = substr($value, 0, stripos($value, ' '));
                }
            }
            $values[$key] = $value;
        }
        if (count($values) > 0) {
            $methods = $this->instance->methods($class);
            foreach ($this->attributes[$this->table] as $value) {
                if (in_array($value, $methods) !== false
                    && in_array(
                        $value,
                        $values
                    ) !== false
                ) {
                    if (isset(
                        $this->data[$this->table][array_search(
                            $value,
                            $values
                        )]
                    )
                    ) {
                        $this->data[$this->table][array_search(
                            $value,
                            $values
                        )]
                            = $this->{$value}(
                            $this->data[$this->table][array_search(
                                $value,
                                $values
                            )]
                        );
                    }
                }
            }
            $datas = $this->query->getData();
            $aligns = false;
            if (count($this->data[$this->table]) > 0) {
                list($aligns, $datas) = $this->changeds($aligns, $datas);
            }
            if ($aligns) {
                $this->query->setData($datas);
                $this->return = $aligns;
            }
        }
        return $this;
    }

    /**
     * @param bool $align
     * @param array $datas
     *
     * @return array
     */
    public function changeds(bool $aligns, array $datas): array
    {
        $type = 'conditions';
        if ($this->typeQuery == 'update') {
            $type = 'fields';
        }
        $values = $datas[array_search($this->table, $this->ids)][$type];
        if ($type == 'conditions') {
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
        foreach ($this->data[$this->table] as $key => $value) {
            if ($type == 'conditions') {
                if ($existOperation) {
                    foreach ($operations as $operation) {
                        if ($value != $values[$operation][$key]) {
                            $datas[array_search(
                                $this->table,
                                $this->ids
                            )][$type][$operation][$key]
                                = $value;
                            if (!$aligns) {
                                $aligns = !$aligns;
                            }
                        }
                    }
                } else {
                    if (in_array($key, array_keys($values)) !== false) {
                        if ($value != $values[$key]) {
                            $datas[array_search(
                                $this->table,
                                $this->ids
                            )][$type][$key]
                                = $value;
                            if (!$aligns) {
                                $aligns = !$aligns;
                            }
                        }
                    }
                }
            } else {
                if (in_array($key, array_keys($values)) !== false) {
                    if ($value != $values[$key]) {
                        $datas[array_search(
                            $this->table,
                            $this->ids
                        )][$type][$key]
                            = $value;
                        if (!$aligns) {
                            $aligns = !$aligns;
                        }
                    }
                }
            }
        }
        return [$aligns, $datas];
    }

    /**
     * @param string $class
     * @param array $datas
     *
     * @return array
     */
    public function convertDatas(string $class, array $datas): array
    {
        $values = [];
        foreach ($this->attributes[$this->table] as $value) {
            $key = $value;
            if (stripos($value, '.') !== false) {
                $value = substr($value, stripos($value, '.') + 1);
                if (stripos($value, ' ') !== false) {
                    $value = substr($value, 0, stripos($value, ' '));
                }
            }
            $values[$key] = $value;
        }
        if (count($values) > 0) {
            $methods = $this->instance->methods($class);
            foreach ($datas as $key => $value) {
                if (in_array($key, $methods) !== false
                    && in_array(
                        $key,
                        $values
                    ) !== false
                ) {
                    $datas[$key] = $this->{$key}($value);
                }
            }
        }
        return $datas;
    }

}
