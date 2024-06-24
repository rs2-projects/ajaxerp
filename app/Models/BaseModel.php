<?php

namespace App\Models;

use App\QueryBuilder\CustomQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BaseModel extends Model
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     */
    public function newEloquentBuilder($query)
    {
        return new CustomQueryBuilder($query);
    }

    /**
     * Delete the model from the database.
     *
     * @return bool|null
     *
     * @throws \LogicException
     */
    public function delete(): ?bool
    {
        $deleteResponse = parent::delete();

        DeletedHistory::create([
            'table_name' => $this->table,
            'reference_id' => $this->id,
            'updated_at' => now(),
            'synced' => false
        ]);

        return $deleteResponse;
    }
}
