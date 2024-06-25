<?php

namespace App\Traits;

use App\Models\UpdatedTable;

trait UpdatedTableTrait
{
    public static function storeTableName($tableName)
    {
        $check = UpdatedTable::where('table_name', $tableName)->first();
        if (empty($check)) {
            UpdatedTable::create([
                'table_name' => $tableName
            ]);
        }
    }
}
