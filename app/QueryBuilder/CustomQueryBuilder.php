<?php

namespace App\QueryBuilder;

use App\Models\DeletedHistory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class CustomQueryBuilder extends Builder
{
    /**
     * Delete records from the database.
     *
     * @return mixed
     */
    public function delete()
    {
        // Get the IDs of the records that are going to be deleted
//        $ids = $this->pluck($this->model->getKeyName())->toArray();
        $ids = $this->pluck('id')->toArray();
        $tableName = $this->model->getTable();

        // Add custom logic before deleting


        // Call the parent delete method
        $deleteResponse = parent::delete();

        // Add custom logic after deleting
        foreach ($ids as $id) {
            DeletedHistory::create([
                'table_name' => $tableName,
                'reference_id' => $id,
                'updated_at' => now(),
                'synced' => false
            ]);
        }

        return $deleteResponse;
    }
}
