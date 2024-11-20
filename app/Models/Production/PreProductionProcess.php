<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreProductionProcess extends BaseModel
{
    use HasFactory;

    protected $table = 'pre_production_processes';
    public $timestamps = false;

    const PROCESS_STATUS_PENDING = 0;
    const PROCESS_STATUS_PROCESSING = 1;
    const PROCESS_STATUS_COMPLETED = 2;
    const PROCESSES = [
        self::PROCESS_STATUS_PENDING => 'Pending',
        self::PROCESS_STATUS_PROCESSING => 'Processing',
        self::PROCESS_STATUS_COMPLETED => 'Completed',
    ];

    const MONITOR_PROCESS_STATUSES = [
        self::PROCESS_STATUS_PENDING => '',
        self::PROCESS_STATUS_PROCESSING => 'On Going',
        self::PROCESS_STATUS_COMPLETED => 'Done',
    ];

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
        'production_staff_id',
        'instruction',
        'process_status',
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

    public function board_materials()
    {
        return $this->hasMany(PreProductionProcessBoard::class, 'pre_production_process_id');
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

    public function process_staff(){

        return $this->belongsTo(ProductionStaff::class, 'production_staff_id');
    }

    public function pre_production(){

        return $this->belongsTo(PreProduction::class, 'pre_production_id');
    }

    public function process_machine(){

        return $this->hasMany(PreProductionProcessMachine::class, 'pre_production_process_id');
    }

    public function process_material(){
    }
}
