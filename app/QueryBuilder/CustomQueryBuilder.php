<?php

namespace App\QueryBuilder;

use App\Models\DeletedHistory;
use App\Traits\UpdatedTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomQueryBuilder extends Builder
{
    use UpdatedTableTrait;

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

    public function update(array $values)
    {
        $updateResponse = parent::update($values);
        self::storeTableName($this->model->getTable());

        $ids = $this->pluck('id')->toArray();
        if (count($ids) > 0) {
            DB::table($this->model->getTable())->whereIn('id', $ids)->where('synced', 1)->update(['synced' => false]);
        }
        return $updateResponse;
    }

    public function create(array $attributes = [])
    {
        $createResponse = parent::create($attributes);
        self::storeTableName($this->model->getTable());

        $ids = $this->pluck('id')->toArray();
        if (count($ids) > 0) {
            DB::table($this->model->getTable())->whereIn('id', $ids)->where('synced', 1)->update(['synced' => false]);
        }
        return $createResponse;
    }
}
