<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionProcess extends Model
{
    use HasFactory;

    protected $table = 'pre_production_processes';
    public $timestamps = false;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    protected $fillable = [
        'pre_production_id',
        'instruction',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function processMachines()
    {
        return $this->hasMany(PreProductionProcessMachine::class, 'pre_production_process_id', 'id');
    }

    public function materials()
    {
        return $this->hasMany(PreProductionProcessMaterial::class, 'pre_production_process_id');
    }

    public function estimated_output()
    {
        return $this->hasMany(PreProductionProcessEstimatedOutput::class, 'pre_production_process_id', 'id')
            ->where('deleted', PreProductionProcessEstimatedOutput::DELETED_NO)
            ->where('status', PreProductionProcessEstimatedOutput::STATUS_ACTIVE);
    }

    public function previousProcess()
    {
        return $this->hasMany(PreProductionProcessPreviousProcess::class, 'pre_production_process_id');
    }
}
