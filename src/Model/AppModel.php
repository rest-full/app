<?php

namespace App\Model;

use Restfull\Error\Exceptions;
use Restfull\ORM\BaseTable;

/**
 *
 */
class AppModel extends BaseTable
{

    /**
     * @param array $tables
     * @param array $options
     *
     * @return AppModel
     * @throws Exceptions
     */
    public function scannigTheMetadata(array $tables, array $options): AppModel
    {
        if (!empty($this->tableRegistory->name)) {
            $this->tableRegistory = $this->newInstance()->metadataScanningExecuted();
        }
        foreach ($tables['main'] as $table) {
            if (empty($this->tableRegistory->name) || stripos($this->tableRegistory->name, $table['table']) === false) {
                if (isset($tables['join'][$table['table']])) {
                    $this->tableRegistory->connectColumnNameWithTableName = !$this->tableRegistory->connectColumnNameWithTableName;
                    $scanningTables['join'][$table['table']] = $tables['join'][$table['table']];
                }
                $scanningTables['main'] = $table;
                $this->scannigTheMetadataOfTheseTables($scanningTables, false);
            }
        }
        if (isset($options['datas'])) {
            $datas = $options['datas'];
            if (count($datas) > 0) {
                $this->dataQuery($datas, $tables['main']);
            }
        }
        return $this;
    }
}
