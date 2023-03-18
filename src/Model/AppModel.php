<?php

namespace App\Model;

use Restfull\Error\Exceptions;
use Restfull\ORM\BaseTable;

/**
 * Description of AppModel
 *
 * @package App\Model
 */
class AppModel extends BaseTable
{

    /**
     * @param array $tables
     * @param array $datas
     *
     * @return AppModel
     * @throws Exceptions
     */
    public function tableRepository(array $tables, array $options = []): AppModel
    {
        $comment = false;
        if (isset($options['comment'])) {
            $comment = $options['comment'];
            unset($options['comment']);
        }
        $registories = $this->http($this->tableRegistory->http)->tableRegistory;
        $count = count($tables['main']);
        $this->assembly($count == 1 ? 'single' : 'several');
        for ($a = 0; $a < $count; $a++) {
            $nameTable = $tables['main'][$a]['table'];
            if (isset($tables['main'][$a]['alias'])) {
                $alias = $tables['main'][$a]['alias'];
                if (!empty($alias)) {
                    $nameTable .= ' as ' . $alias;
                }
            }
            if ($registories->name == '' || stripos($registories->name, $nameTable) === false) {
                $registories = $this->tableRegistory->registory($nameTable)->entityShow(
                    $nameTable,
                    false,
                    $comment
                )->entityColumns($nameTable);
            }
            if (isset($tables['join'][$nameTable])) {
                $registories->joinName = $nameTable;
                $registories->connectColumnNameWithTableName = true;
                $computo = count($tables['join'][$registories->joinName]);
                for ($b = 0; $b < $computo; $b++) {
                    if (count($tables['join'][$registories->joinName][$b]) > 0) {
                        $nameJoin = $tables['join'][$registories->joinName][$b]['table'];
                        if (isset($tables['join'][$registories->joinName][$b]['alias'])) {
                            $alias = $tables['join'][$registories->joinName][$b]['alias'];
                            if (!empty($alias)) {
                                $nameJoin .= ' as ' . $alias;
                            }
                        }
                        $registories->registory($nameJoin, 'join')->entityShow(
                            $nameJoin,
                            true,
                            $comment
                        )->entityColumns($nameJoin);
                    }
                }
                $registories->joinName = '';
            }
        }
        $this->tableRegistory = $registories;
        if (isset($options['datas'])) {
            $datas = $options['datas'];
            if (count($datas) > 0) {
                $this->dataQuery($datas, $tables['main']);
            }
        }
        return $this;
    }

    /**
     * @param array $tables
     * @param array $datas
     *
     * @return $this
     */
    public function tableRepositoryDetails(
        array $tables,
        array $datas = []
    ): AppModel {
        $registories = $this->http($this->tableRegistory->http);
        $count = count($tables['main']);
        $this->assembly($count == 1 ? 'single' : 'several');
        for ($a = 0; $a < $count; $a++) {
            $nameTable = $tables['main'][$a]['table'];
            if (isset($tables['main'][$a]['alias'])) {
                $nameTable .= ' as ' . $tables['main'][$a]['alias'];
            }
            $registories = $this->tableRegistory->registory($nameTable)->entityShow($nameTable, false)->entityColumns(
                $nameTable
            );
        }
        $this->tableRegistory = $registories;
        if (count($datas) > 0) {
            $this->dataQuery($datas, $tables['main']);
        }
        return $this;
    }

}
