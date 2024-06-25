<?php

namespace App\Models;

use App\QueryBuilder\CustomQueryBuilder;
use App\Traits\UpdatedTableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;

class BaseAuthenticatableModel extends Authenticatable
{
    use UpdatedTableTrait;
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

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /*static::creating(function ($model) {
            Log::info('Creating event fired for: ' . get_class($model), ['model' => $model]);
        });*/

        static::created(function ($model) {
            self::storeTableName($model->getTable());
//            Log::info('Created event fired for: ' . get_class($model), ['model' => $model]);
        });

        /*static::updating(function ($model) {
            Log::info('Updating event fired for: ' . get_class($model), ['model' => $model]);
        });*/

        static::updated(function ($model) {
            self::storeTableName($model->getTable());
//            Log::info('Updated event fired for: ' . get_class($model), ['model' => $model]);
        });

        /*static::deleting(function ($model) {
            Log::info('Deleting event fired for: ' . get_class($model), ['model' => $model]);
        });*/

        static::deleted(function ($model) {
            self::storeTableName($model->getTable());
//            Log::info('Deleted event fired for: ' . get_class($model), ['model' => $model]);
        });

        /*static::saving(function ($model) {
            Log::info('Saving event fired for: ' . get_class($model), ['model' => $model]);
        });*/

        static::saved(function ($model) {
            self::storeTableName($model->getTable());
//            Log::info('Saved event fired for: ' . get_class($model), ['model' => $model]);
        });
    }

}


